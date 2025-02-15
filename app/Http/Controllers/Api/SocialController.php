<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialResource;
use App\Models\Social;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SocialController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $socials = Social::get();

        return SocialResource::collection($socials);
    }
}
