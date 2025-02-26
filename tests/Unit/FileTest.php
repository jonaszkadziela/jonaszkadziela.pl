<?php

namespace Tests\Unit;

use App\Models\Document;
use App\Models\File;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    private array $attributes;
    private File $file;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'slug' => '83eebf60-2d36-3984-ba58-ba937df6d02d',
            'storage_path' => 'app/public/test.jpg',
            'mime_type' => 'image/jpeg',
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->file = File::factory()->create($this->attributes);
    }

    public function test_file_attributes(): void
    {
        $this->assertSame($this->attributes['slug'], $this->file->slug);
        $this->assertSame($this->attributes['storage_path'], $this->file->storage_path);
        $this->assertSame($this->attributes['mime_type'], $this->file->mime_type);
        $this->assertTrue($this->attributes['created_at']->equalTo($this->file->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->file->updated_at));
    }

    public function test_file_casts(): void
    {
        $this->assertTrue($this->file->created_at instanceof Carbon);
        $this->assertTrue($this->file->updated_at instanceof Carbon);
    }

    public function test_file_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->file)));
    }

    public function test_file_parent_classes(): void
    {
        $this->assertTrue($this->file instanceof Model);
    }

    public function test_file_documents_relation(): void
    {
        $document = Document::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $document->id,
                'model_type' => Document::class,
                'file_id' => $this->file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertTrue($this->file->documents() instanceof MorphToMany);
        $this->assertCount(1, $this->file->documents()->get());
        $this->assertSame($document->id, $this->file->documents()->first()->id);
        $this->assertSame(File::MAIN_PICTURE, $this->file->documents()->first()->pivot->file_role);
    }

    public function test_file_posts_relation(): void
    {
        $post = Post::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $post->id,
                'model_type' => Post::class,
                'file_id' => $this->file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertTrue($this->file->posts() instanceof MorphToMany);
        $this->assertCount(1, $this->file->posts()->get());
        $this->assertSame($post->id, $this->file->posts()->first()->id);
        $this->assertSame(File::MAIN_PICTURE, $this->file->posts()->first()->pivot->file_role);
    }

    public function test_file_projects_relation(): void
    {
        $project = Project::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $project->id,
                'model_type' => Project::class,
                'file_id' => $this->file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertTrue($this->file->projects() instanceof MorphToMany);
        $this->assertCount(1, $this->file->projects()->get());
        $this->assertSame($project->id, $this->file->projects()->first()->id);
        $this->assertSame(File::MAIN_PICTURE, $this->file->projects()->first()->pivot->file_role);
    }

    public function test_file_get_content_method_when_file_does_not_exist(): void
    {
        $this->assertSame(null, $this->file->getContent());
    }

    public function test_file_get_content_method_when_file_exists(): void
    {
        $fileContent = 'Sample file content';

        Storage::shouldReceive('disk')->andReturnSelf();
        Storage::shouldReceive('exists')->with($this->file->storage_path)->andReturn(true);
        Storage::shouldReceive('get')->with($this->file->storage_path)->andReturn($fileContent);

        $this->assertSame($fileContent, $this->file->getContent());
    }

    public function test_file_get_url_method(): void
    {
        $this->assertSame(secure_url('/files/' . $this->file->slug), $this->file->getUrl());
    }
}
