<?php

namespace Tests\Feature\Api;

use App\Models\Menu;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MenuTest extends TestCase
{
    private Menu $menuWithTranslations;
    private Menu $menuWithoutTranslations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->menuWithTranslations = Menu::factory()->create([
            'name' => 'contact',
            'translations' => [
                'en' => [
                    'contact' => 'Contact',
                ],
                'pl' => [
                    'contact' => 'Kontakt',
                ],
            ],
        ]);

        $this->menuWithoutTranslations = Menu::factory()->create([
            'translations' => null,
        ]);
    }

    private function getMenus(): TestResponse
    {
        return $this->getJson('/api/menus');
    }

    public function test_all_menus_can_be_returned(): void
    {
        $response = $this->getMenus();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'name' => $this->menuWithTranslations->name,
                    'route' => $this->menuWithTranslations->route,
                    'translations' => $this->menuWithTranslations->translations,
                    'isOnlyInFooter' => $this->menuWithTranslations->is_only_in_footer,
                ],
                [
                    'name' => $this->menuWithoutTranslations->name,
                    'route' => $this->menuWithoutTranslations->route,
                    'translations' => [],
                    'isOnlyInFooter' => $this->menuWithoutTranslations->is_only_in_footer,
                ],
            ],
        ]);
    }
}
