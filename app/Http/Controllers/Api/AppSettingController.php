<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class AppSettingController extends Controller
{
    public function languageOptions(): JsonResponse
    {
        $options = collect(config('app.languages'))
            ->map(fn (string $code) => [
                'label' => Lang::get('main.languages.' . $code),
                'value' => $code,
            ])
            ->toArray();

        return response()->json($options);
    }

    public function optionalFeatures(): JsonResponse
    {
        return response()->json([
            'feedback' => config('app.feedback_enabled'),
        ]);
    }
}
