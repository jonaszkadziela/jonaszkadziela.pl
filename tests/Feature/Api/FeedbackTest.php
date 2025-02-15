<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\Storage\EntryModel;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    private function postFeedback(string $type, string $body, array $data = []): TestResponse
    {
        return $this->post('/api/feedback', [
            'type' => $type,
            'body' => $body,
            'data' => $data,
        ], [
            'Referer' => Arr::get($data, 'url') ?? '',
        ]);
    }

    public function test_issue_feedback_can_be_stored_without_telescope_entry(): void
    {
        $payload = [
            'type' => 'issue',
            'body' => 'Error 404 - JonaszKadziela.pl',
            'data' => [
                '_telescope' => Carbon::now()->timestamp * 1000,
                'url' => 'http://jonaszkadziela.test/meet-me',
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
            ],
        ];

        $response = $this->postFeedback($payload['type'], $payload['body'], $payload['data']);

        $response->assertOk();

        $this->assertDatabaseHas('feedback', [
            'type' => $payload['type'],
            'body' => $payload['body'],
            'data' => json_encode([
                ...$payload['data'],
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
                'uri' => '/meet-me',
            ],
            'created_at' => $now,
        ]);

        $payload = [
            'type' => 'issue',
            'body' => 'Error 404 - JonaszKadziela.pl',
            'data' => [
                '_telescope' => $now->timestamp * 1000,
                'url' => 'http://jonaszkadziela.test/meet-me',
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
            ],
        ];

        $response = $this->postFeedback($payload['type'], $payload['body'], $payload['data']);

        $response->assertOk();

        $this->assertDatabaseHas('feedback', [
            'type' => $payload['type'],
            'body' => $payload['body'],
            'data' => json_encode([
                ...$payload['data'],
                'telescopeEntry' => $telescopeEntry->refresh()->toArray(),
            ]),
        ]);
    }
}
