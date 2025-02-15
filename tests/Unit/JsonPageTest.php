<?php

namespace Tests\Unit;

use App\Models\JsonPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class JsonPageTest extends TestCase
{
    private array $attributes;
    private JsonPage $jsonPage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'name' => 'privacy',
            'sections' => [
                [
                    'id' => 'summary',
                    'type' => 'ContainerSection',
                    'class' => 'flex flex-col gap-16 items-center pb-20 pt-16 px-4 relative',
                    'title' => 'summary-title',
                    'body' => 'summary-body',
                    'showButton' => false,
                ],
            ],
            'translations' => [
                'en' => [
                    'summary-title' => 'Summary',
                    'summary-body' => 'Sample body',
                ],
                'pl' => [
                    'summary-title' => 'Podsumowanie',
                    'summary-body' => 'Przykładowa treść',
                ],
            ],
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->jsonPage = JsonPage::factory()->create($this->attributes);
    }

    public function test_json_page_attributes(): void
    {
        $this->assertSame($this->attributes['name'], $this->jsonPage->name);
        $this->assertSame($this->attributes['sections'], $this->jsonPage->sections);
        $this->assertSame($this->attributes['translations'], $this->jsonPage->translations);
        $this->assertTrue($this->attributes['created_at']->equalTo($this->jsonPage->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->jsonPage->updated_at));
    }

    public function test_json_page_casts(): void
    {
        $this->assertTrue(getType($this->jsonPage->sections) === 'array');
        $this->assertTrue(getType($this->jsonPage->translations) === 'array');
        $this->assertTrue($this->jsonPage->created_at instanceof Carbon);
        $this->assertTrue($this->jsonPage->updated_at instanceof Carbon);
    }

    public function test_json_page_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->jsonPage)));
    }

    public function test_json_page_parent_classes(): void
    {
        $this->assertTrue($this->jsonPage instanceof Model);
    }
}
