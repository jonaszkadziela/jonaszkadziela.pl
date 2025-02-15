<?php

namespace Tests\Unit;

use App\Models\Document;
use App\Models\Post;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TagTest extends TestCase
{
    private array $attributes;
    private Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'name' => 'achievement',
            'translations' => [
                'en' => [
                    'achievement' => 'Achievement',
                ],
                'pl' => [
                    'achievement' => 'Osiągnięcie',
                ],
            ],
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->tag = Tag::factory()->create($this->attributes);
    }

    public function test_tag_attributes(): void
    {
        $this->assertSame($this->attributes['name'], $this->tag->name);
        $this->assertSame($this->attributes['translations'], $this->tag->translations);
        $this->assertTrue($this->attributes['created_at']->equalTo($this->tag->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->tag->updated_at));
    }

    public function test_tag_casts(): void
    {
        $this->assertTrue(getType($this->tag->translations) === 'array');
        $this->assertTrue($this->tag->created_at instanceof Carbon);
        $this->assertTrue($this->tag->updated_at instanceof Carbon);
    }

    public function test_tag_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->tag)));
    }

    public function test_tag_parent_classes(): void
    {
        $this->assertTrue($this->tag instanceof Model);
    }

    public function test_tag_documents_relation(): void
    {
        $document = Document::factory()->create();

        DB::table('model_tag')
            ->insert([
                'model_id' => $document->id,
                'model_type' => Document::class,
                'tag_id' => $this->tag->id,
                'order' => 10,
            ]);

        $this->assertTrue($this->tag->documents() instanceof MorphToMany);
        $this->assertCount(1, $this->tag->documents()->get());
        $this->assertSame($document->id, $this->tag->documents()->first()->id);
        $this->assertSame(10, $this->tag->documents()->first()->pivot->order);
    }

    public function test_tag_posts_relation(): void
    {
        $post = Post::factory()->create();

        DB::table('model_tag')
            ->insert([
                'model_id' => $post->id,
                'model_type' => Post::class,
                'tag_id' => $this->tag->id,
                'order' => 10,
            ]);

        $this->assertTrue($this->tag->posts() instanceof MorphToMany);
        $this->assertCount(1, $this->tag->posts()->get());
        $this->assertSame($post->id, $this->tag->posts()->first()->id);
        $this->assertSame(10, $this->tag->posts()->first()->pivot->order);
    }

    public function test_tag_projects_relation(): void
    {
        $project = Project::factory()->create();

        DB::table('model_tag')
            ->insert([
                'model_id' => $project->id,
                'model_type' => Project::class,
                'tag_id' => $this->tag->id,
                'order' => 10,
            ]);

        $this->assertTrue($this->tag->projects() instanceof MorphToMany);
        $this->assertCount(1, $this->tag->projects()->get());
        $this->assertSame($project->id, $this->tag->projects()->first()->id);
        $this->assertSame(10, $this->tag->projects()->first()->pivot->order);
    }
}
