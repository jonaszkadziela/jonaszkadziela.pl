<?php

namespace Tests\Feature\Api;

use App\Models\Social;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SocialTest extends TestCase
{
    private Social $social;

    protected function setUp(): void
    {
        parent::setUp();

        $this->social = Social::factory()->create();
    }

    private function getSocials(): TestResponse
    {
        return $this->getJson('/api/socials');
    }

    public function test_all_socials_can_be_returned(): void
    {
        $response = $this->getSocials();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $this->social->id,
                    'title' => $this->social->title,
                    'link' => $this->social->link,
                    'icon' => $this->social->icon,
                ],
            ],
        ]);
    }
}
