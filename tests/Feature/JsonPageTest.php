<?php

namespace Tests\Feature;

use App\Models\JsonPage;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class JsonPageTest extends TestCase
{
    private JsonPage $jsonPage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->jsonPage = JsonPage::factory()->create([
            'sections' => [
                [
                    'type' => 'ParagraphSection',
                    'id' => 'summary',
                    'title' => 'summary.title',
                    'teleport' => '#left-side',
                    'showTitle' => true,
                    'showSplitter' => true,
                    'data' => [
                        'summary.body',
                    ],
                ],
            ],
            'translations' => [
                'en' => [
                    'summary' => [
                        'title' => 'English title',
                        'body' => 'English body',
                    ],
                ],
                'pl' => [
                    'summary' => [
                        'title' => 'Polish title',
                        'body' => 'Polish body',
                    ],
                ],
            ],
        ]);
    }

    private function getJsonPage(string $name): TestResponse
    {
        return $this->get('/json-pages/' . $name);
    }

    public function test_json_page_can_be_returned(): void
    {
        Carbon::setTestNow(Carbon::now());

        $response = $this->getJsonPage($this->jsonPage->name);

        $response->assertOk();
        $response->assertJson([
            'sections' => $this->jsonPage->sections,
            'translations' => $this->jsonPage->translations,
            'updatedAt' => $this->jsonPage->updated_at->diffForHumans() . ' (' . $this->jsonPage->updated_at->toDateString() . ')',
        ]);
    }
}
