<?php

namespace Tests\Feature\Api;

use App\Models\Document;
use App\Models\Post;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class GlobalSearchTest extends TestCase
{
    private Document $documentWithTag;
    private Post $postWithTag;
    private Project $projectWithTag;
    private Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now());

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

        $this->documentWithTag = Document::factory()->create();
        $this->postWithTag = Post::factory()->create();
        $this->projectWithTag = Project::factory()->create();

        $this->documentWithTag->tags()->save($this->tag, ['order' => 0]);
        $this->postWithTag->tags()->save($this->tag, ['order' => 0]);
        $this->projectWithTag->tags()->save($this->tag, ['order' => 0]);
    }

    private function searchByTags(array $query = []): TestResponse
    {
        return $this->getJson(url()->query('/api/search/by-tags', $query));
    }

    public function test_error_422_is_returned_when_tags_parameter_is_missing(): void
    {
        $response = $this->searchByTags();

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_only_relevant_results_are_returned(): void
    {
        $otherTag = Tag::factory()->create(['name' => 'other']);

        $documentWithOtherTag = Document::factory()->create();
        $postWithOtherTag = Post::factory()->create();
        $projectWithOtherTag = Document::factory()->create();

        $documentWithOtherTag->tags()->save($otherTag, ['order' => 0]);
        $postWithOtherTag->tags()->save($otherTag, ['order' => 0]);
        $projectWithOtherTag->tags()->save($otherTag, ['order' => 0]);

        $response = $this->searchByTags(['tags' => ['featured']]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'results' => [
                    'documents' => [
                        [
                            'slug' => $this->documentWithTag->slug,
                        ],
                    ],
                    'posts' => [
                        [
                            'slug' => $this->postWithTag->slug,
                        ],
                    ],
                    'projects' => [
                        [
                            'slug' => $this->projectWithTag->slug,
                        ],
                    ],
                ],
                'tags' => [
                    [
                        'name' => $this->tag->name,
                        'translations' => $this->tag->translations,
                    ],
                ],
            ],
        ]);
        $response->assertJsonMissing([
            'slug' => $documentWithOtherTag->slug,
        ]);
        $response->assertJsonMissing([
            'slug' => $postWithOtherTag->slug,
        ]);
        $response->assertJsonMissing([
            'slug' => $projectWithOtherTag->slug,
        ]);
    }
}
