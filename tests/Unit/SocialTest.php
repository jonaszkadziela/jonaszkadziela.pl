<?php

namespace Tests\Unit;

use App\Models\Social;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SocialTest extends TestCase
{
    private array $attributes;
    private Social $social;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'title' => 'Facebook',
            'link' => 'https://facebook.com/test',
            'icon' => 'fa-brands fa-facebook-f',
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->social = Social::factory()->create($this->attributes);
    }

    public function test_social_attributes(): void
    {
        $this->assertSame($this->attributes['title'], $this->social->title);
        $this->assertSame($this->attributes['link'], $this->social->link);
        $this->assertSame($this->attributes['icon'], $this->social->icon);
        $this->assertTrue($this->attributes['created_at']->equalTo($this->social->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->social->updated_at));
    }

    public function test_social_casts(): void
    {
        $this->assertTrue($this->social->created_at instanceof Carbon);
        $this->assertTrue($this->social->updated_at instanceof Carbon);
    }

    public function test_social_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->social)));
    }

    public function test_social_parent_classes(): void
    {
        $this->assertTrue($this->social instanceof Model);
    }
}
