<?php

namespace Tests\Feature\Api;

use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class PostTest extends TestCase
{
    private Post $postWithImage;
    private Post $postWithoutRelations;
    private Post $postWithTag;
    private File $file;
    private Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now());

        $this->file = File::factory()->create();
        $this->tag = Tag::factory()->create([
            'name' => 'featured',
            'translations' => [
                'en' => [
                    'featured' => 'Featured',
                ],
                'pl' => [
                    'featured' => 'Wyróżnienie',
                ],
            ],
        ]);

        $this->postWithImage = Post::factory()->create();
        $this->postWithoutRelations = Post::factory()->create();
        $this->postWithTag = Post::factory()->create();

        $this->postWithImage->files()->save($this->file, [
            'file_role' => File::MAIN_PICTURE,
        ]);

        $this->postWithTag->tags()->save($this->tag, [
            'order' => 0,
        ]);
    }

    private function getPosts(array $query = []): TestResponse
    {
        return $this->getJson(url()->query('/api/posts', $query));
    }

    private function getPost(string $slugWithId): TestResponse
    {
        return $this->getJson('/api/posts/' . $slugWithId);
    }

    public function test_all_posts_can_be_returned(): void
    {
        $response = $this->getPosts();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'slug' => $this->postWithImage->slug,
                    'title' => $this->postWithImage->title,
                    'body' => $this->postWithImage->body,
                    'translations' => $this->postWithImage->translations,
                    'publishedAt' => $this->postWithImage->published_at->diffForHumans() . ' (' . $this->postWithImage->published_at->toDateString() . ')',
                    'tags' => [],
                    'image' => $this->postWithImage->getMainPicture()->getUrl(),
                    'user' => null,
                ],
                [
                    'slug' => $this->postWithoutRelations->slug,
                    'title' => $this->postWithoutRelations->title,
                    'body' => $this->postWithoutRelations->body,
                    'translations' => $this->postWithoutRelations->translations,
                    'publishedAt' => $this->postWithoutRelations->published_at->diffForHumans() . ' (' . $this->postWithoutRelations->published_at->toDateString() . ')',
                    'tags' => [],
                    'image' => null,
                    'user' => null,
                ],
                [
                    'slug' => $this->postWithTag->slug,
                    'title' => $this->postWithTag->title,
                    'body' => $this->postWithTag->body,
                    'translations' => $this->postWithTag->translations,
                    'publishedAt' => $this->postWithTag->published_at->diffForHumans() . ' (' . $this->postWithTag->published_at->toDateString() . ')',
                    'tags' => [
                        [
                            'name' => $this->tag->name,
                            'translations' => $this->tag->translations,
                        ],
                    ],
                    'image' => null,
                    'user' => null,
                ],
            ],
        ]);
    }

    public function test_posts_can_be_filtered_by_name(): void
    {
        $this->postWithoutRelations->update([
            'title' => 'title',
            'translations' => [
                'en' => [
                    'title' => 'Sample title',
                ],
                'pl' => [
                    'title' => 'Przykładowy tytuł',
                ],
            ],
        ]);

        Lang::setLocale('en');

        $response = $this->getPosts(['title' => 'Sample']);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'slug' => $this->postWithoutRelations->slug,
                    'title' => $this->postWithoutRelations->title,
                    'body' => $this->postWithoutRelations->body,
                    'translations' => $this->postWithoutRelations->translations,
                    'publishedAt' => $this->postWithoutRelations->published_at->diffForHumans() . ' (' . $this->postWithoutRelations->published_at->toDateString() . ')',
                    'tags' => [],
                    'image' => null,
                    'user' => null,
                ],
            ],
        ]);
        $response->assertJsonMissing([
            'slug' => $this->postWithImage->slug,
        ]);
        $response->assertJsonMissing([
            'slug' => $this->postWithTag->slug,
        ]);
    }

    public function test_posts_can_be_filtered_by_tag(): void
    {
        $response = $this->getPosts(['tags' => ['featured']]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'slug' => $this->postWithTag->slug,
                    'title' => $this->postWithTag->title,
                    'body' => $this->postWithTag->body,
                    'translations' => $this->postWithTag->translations,
                    'publishedAt' => $this->postWithTag->published_at->diffForHumans() . ' (' . $this->postWithTag->published_at->toDateString() . ')',
                    'tags' => [
                        [
                            'name' => $this->tag->name,
                            'translations' => $this->tag->translations,
                        ],
                    ],
                    'image' => null,
                    'user' => null,
                ],
            ],
        ]);
        $response->assertJsonMissing([
            'slug' => $this->postWithImage->slug,
        ]);
        $response->assertJsonMissing([
            'slug' => $this->postWithoutRelations->slug,
        ]);
    }

    public function test_error_404_is_returned_when_post_does_not_exist(): void
    {
        $response = $this->getPost('wrong');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_post_can_be_returned(): void
    {
        $response = $this->getPost($this->postWithImage->slug . '-' . $this->postWithImage->id);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'slug' => $this->postWithImage->slug,
                'title' => $this->postWithImage->title,
                'body' => $this->postWithImage->body,
                'translations' => $this->postWithImage->translations,
                'publishedAt' => $this->postWithImage->published_at->diffForHumans() . ' (' . $this->postWithImage->published_at->toDateString() . ')',
                'tags' => [],
                'image' => $this->postWithImage->getMainPicture()->getUrl(),
                'user' => null,
            ],
        ]);
    }
}
