<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UserSettingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.languages', ['en', 'pl']);
    }

    public function test_correct_options_are_returned_when_language_is_set_to_english(): void
    {
        Session::put('language', 'en');

        $response = $this->get('/language-options');

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
        Session::put('language', 'pl');

        $response = $this->get('/language-options');

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

    public function test_language_can_be_changed_to_english(): void
    {
        $response = $this->get('/language/en');

        $response->assertRedirect();
        $response->assertSessionHas('language', 'en');
    }

    public function test_language_can_be_changed_to_polish(): void
    {
        $response = $this->get('/language/pl');

        $response->assertRedirect();
        $response->assertSessionHas('language', 'pl');
    }

    public function test_theme_can_be_changed_to_dark(): void
    {
        Session::put('theme', 'light');

        $response = $this->post('/theme/dark');

        $response->assertOk();
        $response->assertJson([
            'theme' => 'dark',
        ]);

        $response->assertSessionHas('theme', 'dark');
    }

    public function test_theme_can_be_changed_to_light(): void
    {
        Session::put('theme', 'dark');

        $response = $this->post('/theme/light');

        $response->assertOk();
        $response->assertJson([
            'theme' => 'light',
        ]);

        $response->assertSessionHas('theme', 'light');
    }
}
