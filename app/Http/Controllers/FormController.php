<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\User;
use App\Notifications\ContactFormMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function contact(ContactFormRequest $request): JsonResponse
    {
        $contactFormMessage = new ContactFormMessage($request->email, $request->name, $request->message);

        DatabaseNotification::create([
            'id' => Str::uuid(),
            'type' => ContactFormMessage::class,
            'notifiable_type' => User::class,
            'notifiable_id' => 0,
            'data' => $contactFormMessage->toArray(),
        ]);

        Notification::route('mail', [config('mail.from.address') => config('mail.from.name')])
            ->notifyNow($contactFormMessage);

        return response()->json();
    }
}
