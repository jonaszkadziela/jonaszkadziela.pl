<?php

namespace Tests\Feature\Api;

use App\Models\File;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    private Project $projectWithImage;
    private Project $projectWithoutRelations;
    private Project $projectWithTag;
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

        $this->projectWithImage = Project::factory()->create();
        $this->projectWithoutRelations = Project::factory()->create();
        $this->projectWithTag = Project::factory()->create();

        $this->projectWithImage->files()->save($this->file, [
            'file_role' => File::MAIN_PICTURE,
        ]);

        $this->projectWithTag->tags()->save($this->tag, [
            'order' => 0,
        ]);
    }

    private function getProjects(array $query = []): TestResponse
    {
        return $this->getJson(url()->query('/api/projects', $query));
    }

    private function getProject(string $slug): TestResponse
    {
        return $this->getJson('/api/projects/' . $slug);
    }

    public function test_all_projects_can_be_returned(): void
    {
        $response = $this->getProjects();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'slug' => $this->projectWithImage->slug,
                    'title' => $this->projectWithImage->title,
                    'body' => $this->projectWithImage->body,
                    'link' => $this->projectWithImage->link,
                    'translations' => $this->projectWithImage->translations,
                    'isProBono' => $this->projectWithImage->is_pro_bono,
                    'startedAt' => $this->projectWithImage->started_at->isoFormat('MMM Y'),
                    'finishedAt' => $this->projectWithImage->finished_at->isoFormat('MMM Y'),
                    'tags' => [],
                    'image' => $this->projectWithImage->getMainPicture()->getUrl(),
                    'isImagePhoneRender' => false,
                    'route' => '/portfolio/' . $this->projectWithImage->slug,
                ],
                [
                    'slug' => $this->projectWithoutRelations->slug,
                    'title' => $this->projectWithoutRelations->title,
                    'body' => $this->projectWithoutRelations->body,
                    'link' => $this->projectWithoutRelations->link,
                    'translations' => $this->projectWithoutRelations->translations,
                    'isProBono' => $this->projectWithoutRelations->is_pro_bono,
                    'startedAt' => $this->projectWithoutRelations->started_at->isoFormat('MMM Y'),
                    'finishedAt' => $this->projectWithoutRelations->finished_at->isoFormat('MMM Y'),
                    'tags' => [],
                    'image' => null,
                    'isImagePhoneRender' => false,
                    'route' => '/portfolio/' . $this->projectWithoutRelations->slug,
                ],
                [
                    'slug' => $this->projectWithTag->slug,
                    'title' => $this->projectWithTag->title,
                    'body' => $this->projectWithTag->body,
                    'link' => $this->projectWithTag->link,
                    'translations' => $this->projectWithTag->translations,
                    'isProBono' => $this->projectWithTag->is_pro_bono,
                    'startedAt' => $this->projectWithTag->started_at->isoFormat('MMM Y'),
                    'finishedAt' => $this->projectWithTag->finished_at->isoFormat('MMM Y'),
                    'tags' => [
                        [
                            'name' => $this->tag->name,
                            'translations' => $this->tag->translations,
                        ],
                    ],
                    'image' => null,
                    'isImagePhoneRender' => false,
                    'route' => '/portfolio/' . $this->projectWithTag->slug,
                ],
            ],
        ]);
    }

    public function test_projects_can_be_filtered_by_tag(): void
    {
        $response = $this->getProjects(['tags' => ['featured']]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'slug' => $this->projectWithTag->slug,
                    'title' => $this->projectWithTag->title,
                    'body' => $this->projectWithTag->body,
                    'link' => $this->projectWithTag->link,
                    'translations' => $this->projectWithTag->translations,
                    'isProBono' => $this->projectWithTag->is_pro_bono,
                    'startedAt' => $this->projectWithTag->started_at->isoFormat('MMM Y'),
                    'finishedAt' => $this->projectWithTag->finished_at->isoFormat('MMM Y'),
                    'tags' => [
                        [
                            'name' => $this->tag->name,
                            'translations' => $this->tag->translations,
                        ],
                    ],
                    'image' => null,
                    'isImagePhoneRender' => false,
                    'route' => '/portfolio/' . $this->projectWithTag->slug,
                ],
            ],
        ]);
        $response->assertJsonMissing([
            'slug' => $this->projectWithImage->slug,
        ]);
        $response->assertJsonMissing([
            'slug' => $this->projectWithoutRelations->slug,
        ]);
    }

    public function test_error_404_is_returned_when_project_does_not_exist(): void
    {
        $response = $this->getProject('wrong');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_project_can_be_returned(): void
    {
        $response = $this->getProject($this->projectWithImage->slug);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'slug' => $this->projectWithImage->slug,
                'title' => $this->projectWithImage->title,
                'body' => $this->projectWithImage->body,
                'link' => $this->projectWithImage->link,
                'translations' => $this->projectWithImage->translations,
                'isProBono' => $this->projectWithImage->is_pro_bono,
                'startedAt' => $this->projectWithImage->started_at->isoFormat('MMM Y'),
                'finishedAt' => $this->projectWithImage->finished_at->isoFormat('MMM Y'),
                'tags' => [],
                'image' => $this->projectWithImage->getMainPicture()->getUrl(),
                'isImagePhoneRender' => false,
                'route' => '/portfolio/' . $this->projectWithImage->slug,
            ],
        ]);
    }
}
