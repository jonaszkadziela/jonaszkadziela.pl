<?php

namespace Tests\Unit;

use App\Models\File;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    private array $attributes;
    private Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'slug' => 'sample-project',
            'title' => 'title',
            'body' => 'body',
            'link' => 'https://sample-project.test',
            'translations' => [
                'en' => [
                    'title' => 'Sample Project',
                    'body' => 'This is a sample project',
                ],
                'pl' => [
                    'title' => 'Sample Projekt',
                    'body' => 'To przykładowy projekt',
                ],
            ],
            'is_pro_bono' => false,
            'started_at' => Carbon::parse('2024-11-01 12:00:00'),
            'finished_at' => Carbon::parse('2024-12-01 12:00:00'),
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->project = Project::factory()->create($this->attributes);
    }

    public function test_project_attributes(): void
    {
        $this->assertSame($this->attributes['slug'], $this->project->slug);
        $this->assertSame($this->attributes['title'], $this->project->title);
        $this->assertSame($this->attributes['body'], $this->project->body);
        $this->assertSame($this->attributes['link'], $this->project->link);
        $this->assertSame($this->attributes['translations'], $this->project->translations);
        $this->assertSame($this->attributes['is_pro_bono'], $this->project->is_pro_bono);
        $this->assertTrue($this->attributes['started_at']->equalTo($this->project->started_at));
        $this->assertTrue($this->attributes['finished_at']->equalTo($this->project->finished_at));
        $this->assertTrue($this->attributes['created_at']->equalTo($this->project->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->project->updated_at));
    }

    public function test_project_casts(): void
    {
        $this->assertTrue(getType($this->project->translations) === 'array');
        $this->assertTrue(getType($this->project->is_pro_bono) === 'boolean');
        $this->assertTrue($this->project->started_at instanceof Carbon);
        $this->assertTrue($this->project->finished_at instanceof Carbon);
        $this->assertTrue($this->project->created_at instanceof Carbon);
        $this->assertTrue($this->project->updated_at instanceof Carbon);
    }

    public function test_project_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->project)));
    }

    public function test_project_interfaces(): void
    {
        $this->assertTrue(in_array(Sitemapable::class, class_implements($this->project)));
    }

    public function test_project_parent_classes(): void
    {
        $this->assertTrue($this->project instanceof Model);
    }

    public function test_project_files_relation(): void
    {
        $file = File::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $this->project->id,
                'model_type' => Project::class,
                'file_id' => $file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertTrue($this->project->files() instanceof MorphToMany);
        $this->assertCount(1, $this->project->files()->get());
        $this->assertSame($file->id, $this->project->files()->first()->id);
        $this->assertSame(File::MAIN_PICTURE, $this->project->files()->first()->pivot->file_role);
    }

    public function test_project_tags_relation(): void
    {
        $tag = Tag::factory()->create();

        DB::table('model_tag')
            ->insert([
                'model_id' => $this->project->id,
                'model_type' => Project::class,
                'tag_id' => $tag->id,
                'order' => 10,
            ]);

        $this->assertTrue($this->project->tags() instanceof MorphToMany);
        $this->assertCount(1, $this->project->tags()->get());
        $this->assertSame($tag->id, $this->project->tags()->first()->id);
        $this->assertSame(10, $this->project->tags()->first()->pivot->order);
    }

    public function test_project_get_main_picture_method(): void
    {
        $file = File::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $this->project->id,
                'model_type' => Project::class,
                'file_id' => $file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertSame($file->id, $this->project->getMainPicture()->id);
    }

    public function test_project_to_sitemap_tag_method(): void
    {
        $file = File::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $this->project->id,
                'model_type' => Project::class,
                'file_id' => $file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $sitemapTag = $this->project->toSitemapTag();

        $this->assertTrue($sitemapTag instanceof Url);
        $this->assertSame('/portfolio/' . $this->project->slug, $sitemapTag->url);
        $this->assertSame(Url::CHANGE_FREQUENCY_MONTHLY, $sitemapTag->changeFrequency);
        $this->assertSame($this->project->updated_at->toAtomString(), $sitemapTag->lastModificationDate->toAtomString());
        $this->assertSame(0.5, $sitemapTag->priority);

        $this->assertCount(1, $sitemapTag->images);
        $this->assertSame($file->getUrl(), $sitemapTag->images[0]->url);
        $this->assertSame(Arr::get($this->project->translations, Lang::getFallback() . '.title'), $sitemapTag->images[0]->caption);
    }
}
