<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Notifications\ContactFormMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class FormController extends Controller
{
    public function contact(ContactFormRequest $request): JsonResponse
    {
        Notification::route('mail', config('mail.from.address'))
            ->notifyNow(new ContactFormMessage($request->email, $request->name, $request->message));

        return response()->json();
    }
}
