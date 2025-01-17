<?php

namespace App\Http\Controllers;

use App\Models\JsonPage;
use Illuminate\Http\JsonResponse;

class JsonPageController extends Controller
{
    public function show(JsonPage $jsonPage): JsonResponse
    {
        return response()->json([
            'sections' => $jsonPage->sections,
            'translations' => $jsonPage->translations,
            'updatedAt' => $jsonPage->updated_at->diffForHumans() . ' (' . $jsonPage->updated_at->toDateString() . ')',
        ]);
    }
}
