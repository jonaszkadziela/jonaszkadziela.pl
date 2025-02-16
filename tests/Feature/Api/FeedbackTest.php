<?php

namespace Tests\Feature\Api;

use App\Models\Feedback;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\Storage\EntryModel;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    private array $payload = [
        'type' => Feedback::FEEDBACK_ISSUE,
        'body' => 'Error 404 - JonaszKadziela.pl',
        'data' => [
            '_telescope' => 1739642093167,
            'url' => 'http://jonaszkadziela.test/error',
            'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
        ],
    ];

    private function postFeedback(array $payload): TestResponse
    {
        return $this->postJson('/api/feedback', $payload, [
            'Referer' => Arr::get($payload, 'data.url') ?? '',
        ]);
    }

    public function test_error_422_is_returned_when_type_parameter_is_missing(): void
    {
        $response = $this->postFeedback(Arr::except($this->payload, 'type'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_error_422_is_returned_when_body_parameter_is_missing(): void
    {
        $response = $this->postFeedback(Arr::except($this->payload, 'body'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_issue_feedback_can_be_stored_without_telescope_entry(): void
    {
        $response = $this->postFeedback($this->payload);

        $response->assertOk();

        $this->assertDatabaseHas('feedback', [
            'type' => $this->payload['type'],
            'body' => $this->payload['body'],
            'data' => json_encode([
                ...$this->payload['data'],
                'telescopeEntry' => null,
            ]),
        ]);
    }

    public function test_issue_feedback_can_be_stored_with_telescope_entry(): void
    {
        $now = Carbon::now();

        $telescopeEntry = EntryModel::factory()->create([
            'type' => EntryType::REQUEST,
            'content' => [
                'ip_address' => '127.0.0.1',
                'uri' => '/error',
            ],
            'created_at' => $now,
        ]);

        $this->payload['data']['_telescope'] = $now->timestamp * 1000;

        $response = $this->postFeedback($this->payload);

        $response->assertOk();

        $this->assertDatabaseHas('feedback', [
            'type' => $this->payload['type'],
            'body' => $this->payload['body'],
            'data' => json_encode([
                ...$this->payload['data'],
                'telescopeEntry' => $telescopeEntry->refresh()->toArray(),
            ]),
        ]);
    }
}
