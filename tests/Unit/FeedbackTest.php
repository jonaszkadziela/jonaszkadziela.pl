<?php

namespace Tests\Unit;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    private array $attributes;
    private Feedback $feedback;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'type' => Feedback::FEEDBACK_ISSUE,
            'body' => 'Error 404 - JonaszKadziela.pl',
            'data' => [
                'someText' => 'Sample text',
                'someNumber' => 123,
            ],
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->feedback = Feedback::factory()->create($this->attributes);
    }

    public function test_feedback_attributes(): void
    {
        $this->assertSame($this->attributes['type'], $this->feedback->type);
        $this->assertSame($this->attributes['body'], $this->feedback->body);
        $this->assertSame($this->attributes['data'], $this->feedback->data);
        $this->assertTrue($this->attributes['created_at']->equalTo($this->feedback->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->feedback->updated_at));
    }

    public function test_feedback_casts(): void
    {
        $this->assertTrue(getType($this->feedback->data) === 'array');
        $this->assertTrue($this->feedback->created_at instanceof Carbon);
        $this->assertTrue($this->feedback->updated_at instanceof Carbon);
    }

    public function test_feedback_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->feedback)));
    }

    public function test_feedback_parent_classes(): void
    {
        $this->assertTrue($this->feedback instanceof Model);
    }
}
