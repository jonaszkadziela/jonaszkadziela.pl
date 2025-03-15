<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AppSettingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.languages', ['en', 'pl']);
    }

    public function test_correct_options_are_returned_when_language_is_set_to_english(): void
    {
        $response = $this->getJson('/api/language-options', [
            'X-Language' => 'en',
        ]);

        $response->assertOk();
        $response->assertJson([
            [
                'label' => 'English',
                'value' => 'en',
            ],
            [
                'label' => 'Polish',
                'value' => 'pl',
            ],
        ]);
    }

    public function test_correct_options_are_returned_when_language_is_set_to_polish(): void
    {
        $response = $this->getJson('/api/language-options', [
            'X-Language' => 'pl',
        ]);

        $response->assertOk();
        $response->assertJson([
            [
                'label' => 'Angielski (English)',
                'value' => 'en',
            ],
            [
                'label' => 'Polski (Polish)',
                'value' => 'pl',
            ],
        ]);
    }

    public function test_optional_features_can_be_returned(): void
    {
        $response = $this->getJson('/api/optional-features');

        $response->assertOk();
        $response->assertJson([
            'feedback' => config('app.feedback_enabled'),
        ]);
    }
}
