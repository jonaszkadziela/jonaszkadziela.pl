<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\Storage\EntryModel;

class FeedbackController extends Controller
{
    public function store(CreateFeedbackRequest $request): JsonResponse
    {
        $telescopeEntry = null;

        if (Arr::has($request->data, '_telescope')) {
            $timestamp = Carbon::parse($request->data['_telescope'] / 1000);
            $telescopeEntry = EntryModel::where('type', '=', EntryType::REQUEST)
                ->whereJsonContains('content->ip_address', $request->ip())
                ->whereJsonContains('content->uri', Str::after($request->header('referer'), $request->schemeAndHttpHost()))
                ->whereBetween('created_at', [$timestamp->copy()->subSeconds(3), $timestamp->copy()->addSeconds(3)])
                ->orderBy('created_at', 'desc')
                ->first();
        }

        Feedback::create([
            'type' => $request->type,
            'body' => $request->body,
            'data' => [
                ...$request->data,
                'telescopeEntry' => $telescopeEntry?->toArray(),
            ],
        ]);

        return response()->json();
    }
}
