<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CspReportController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        Log::warning(class_basename($this) . ': CSP violation from IP address ' . ($request->ip() ?? 'Unknown'), $data);

        return response()->json();
    }
}
