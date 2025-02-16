<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Notifications\ContactFormMessage;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class FormTest extends TestCase
{
    private array $payload = [
        'name' => 'John Doe',
        'email' => 'john.doe@domain.test',
        'message' => 'Test message',
    ];

    private function postContact(array $payload): TestResponse
    {
        return $this->postJson('/api/contact', $payload);
    }

    public function test_error_422_is_returned_when_name_parameter_is_missing(): void
    {
        $response = $this->postContact(Arr::except($this->payload, 'name'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_error_422_is_returned_when_email_parameter_is_missing(): void
    {
        $response = $this->postContact(Arr::except($this->payload, 'email'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_error_422_is_returned_when_message_parameter_is_missing(): void
    {
        $response = $this->postContact(Arr::except($this->payload, 'message'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_contact_form_can_be_processed(): void
    {
        Notification::fake();

        $uuid = Str::freezeUuids();

        $response = $this->postContact($this->payload);

        $contactFormMessage = new ContactFormMessage($this->payload['email'], $this->payload['name'], $this->payload['message']);

        $this->assertDatabaseHas('notifications', [
            'id' => $uuid->toString(),
            'type' => ContactFormMessage::class,
            'notifiable_type' => User::class,
            'notifiable_id' => 0,
            'data' => json_encode($contactFormMessage->toArray()),
        ]);

        Notification::assertSentTimes(ContactFormMessage::class, 1);
        Notification::assertSentOnDemand(
            ContactFormMessage::class,
            fn (ContactFormMessage $notification, array $channels, object $notifiable) => $notifiable->routes['mail'] === [config('mail.from.address') => config('mail.from.name')],
        );

        Str::createUuidsNormally();

        $response->assertOk();
    }
}
