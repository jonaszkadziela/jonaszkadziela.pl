<?php

namespace App\Http\Controllers;

use App\Http\Resources\JsonPageResource;
use App\Models\JsonPage;

class JsonPageController extends Controller
{
    public function show(JsonPage $jsonPage): JsonPageResource
    {
        return JsonPageResource::make($jsonPage);
    }
}
