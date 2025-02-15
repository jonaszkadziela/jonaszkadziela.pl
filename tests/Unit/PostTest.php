<?php

namespace Tests\Unit;

use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostTest extends TestCase
{
    private array $attributes;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'slug' => 'sample-post',
            'title' => 'Sample Post',
            'body' => 'sample-post-body',
            'translations' => [
                'en' => [
                    'sample-post-body' => 'This is a sample post',
                ],
                'pl' => [
                    'sample-post-body' => 'To przykładowy post',
                ],
            ],
            'published_at' => Carbon::parse('2025-02-01 12:00:00'),
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->post = Post::factory()->create($this->attributes);
    }

    public function test_post_attributes(): void
    {
        $this->assertSame($this->attributes['slug'], $this->post->slug);
        $this->assertSame($this->attributes['title'], $this->post->title);
        $this->assertSame($this->attributes['body'], $this->post->body);
        $this->assertSame($this->attributes['translations'], $this->post->translations);
        $this->assertTrue($this->attributes['published_at']->equalTo($this->post->published_at));
        $this->assertTrue($this->attributes['created_at']->equalTo($this->post->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->post->updated_at));
    }

    public function test_post_casts(): void
    {
        $this->assertTrue(getType($this->post->translations) === 'array');
        $this->assertTrue($this->post->published_at instanceof Carbon);
        $this->assertTrue($this->post->created_at instanceof Carbon);
        $this->assertTrue($this->post->updated_at instanceof Carbon);
    }

    public function test_post_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->post)));
    }

    public function test_post_parent_classes(): void
    {
        $this->assertTrue($this->post instanceof Model);
    }

    public function test_post_user_relation(): void
    {
        $user = User::factory()->create();

        $this->post->user_id = $user->id;
        $this->post->save();

        $this->assertTrue($this->post->user() instanceof BelongsTo);
        $this->assertCount(1, $this->post->user()->get());
        $this->assertSame($user->id, $this->post->user()->first()->id);
    }

    public function test_post_files_relation(): void
    {
        $file = File::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $this->post->id,
                'model_type' => Post::class,
                'file_id' => $file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertTrue($this->post->files() instanceof MorphToMany);
        $this->assertCount(1, $this->post->files()->get());
        $this->assertSame($file->id, $this->post->files()->first()->id);
        $this->assertSame(File::MAIN_PICTURE, $this->post->files()->first()->pivot->file_role);
    }

    public function test_post_tags_relation(): void
    {
        $tag = Tag::factory()->create();

        DB::table('model_tag')
            ->insert([
                'model_id' => $this->post->id,
                'model_type' => Post::class,
                'tag_id' => $tag->id,
                'order' => 10,
            ]);

        $this->assertTrue($this->post->tags() instanceof MorphToMany);
        $this->assertCount(1, $this->post->tags()->get());
        $this->assertSame($tag->id, $this->post->tags()->first()->id);
        $this->assertSame(10, $this->post->tags()->first()->pivot->order);
    }

    public function test_post_get_main_picture_method(): void
    {
        $file = File::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $this->post->id,
                'model_type' => Post::class,
                'file_id' => $file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertSame($file->id, $this->post->getMainPicture()->id);
    }
}
