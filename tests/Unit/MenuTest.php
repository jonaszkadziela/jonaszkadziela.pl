<?php

namespace Tests\Unit;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MenuTest extends TestCase
{
    private array $attributes;
    private Menu $menu;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'name' => 'home',
            'route' => '/',
            'translations' => [
                'en' => [
                    'home' => 'Home',
                ],
                'pl' => [
                    'home' => 'Strona główna',
                ],
            ],
            'is_only_in_footer' => false,
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->menu = Menu::factory()->create($this->attributes);
    }

    public function test_menu_attributes(): void
    {
        $this->assertSame($this->attributes['name'], $this->menu->name);
        $this->assertSame($this->attributes['route'], $this->menu->route);
        $this->assertSame($this->attributes['translations'], $this->menu->translations);
        $this->assertSame($this->attributes['is_only_in_footer'], $this->menu->is_only_in_footer);
        $this->assertTrue($this->attributes['created_at']->equalTo($this->menu->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->menu->updated_at));
    }

    public function test_menu_casts(): void
    {
        $this->assertTrue(getType($this->menu->translations) === 'array');
        $this->assertTrue(getType($this->menu->is_only_in_footer) === 'boolean');
        $this->assertTrue($this->menu->created_at instanceof Carbon);
        $this->assertTrue($this->menu->updated_at instanceof Carbon);
    }

    public function test_menu_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->menu)));
    }

    public function test_menu_parent_classes(): void
    {
        $this->assertTrue($this->menu instanceof Model);
    }
}
