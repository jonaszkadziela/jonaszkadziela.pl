<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TagTest extends TestCase
{
    private Tag $tagWithTranslations;
    private Tag $tagWithoutTranslations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tagWithTranslations = Tag::factory()->create([
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

        $this->tagWithoutTranslations = Tag::factory()->create([
            'translations' => null,
        ]);
    }

    private function getTags(): TestResponse
    {
        return $this->getJson('/api/tags');
    }

    public function test_all_tags_can_be_returned(): void
    {
        $response = $this->getTags();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'name' => $this->tagWithTranslations->name,
                    'translations' => $this->tagWithTranslations->translations,
                ],
                [
                    'name' => $this->tagWithoutTranslations->name,
                    'translations' => [],
                ],
            ],
        ]);
    }
}
