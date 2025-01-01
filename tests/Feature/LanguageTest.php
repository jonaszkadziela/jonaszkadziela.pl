<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.languages', ['en', 'pl']);
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

    public function test_correct_options_are_returned_when_language_is_set_to_english(): void
    {
        App::setLocale('en');

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
        App::setLocale('pl');

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
}
