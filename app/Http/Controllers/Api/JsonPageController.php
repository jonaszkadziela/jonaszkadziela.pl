<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JsonPageResource;
use App\Models\JsonPage;

class JsonPageController extends Controller
{
    public function show(JsonPage $jsonPage): JsonPageResource
    {
        return JsonPageResource::make($jsonPage);
    }
}
