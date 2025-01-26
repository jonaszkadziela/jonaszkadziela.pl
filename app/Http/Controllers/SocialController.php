<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Http\JsonResponse;

class SocialController extends Controller
{
    public function index(): JsonResponse
    {
        $socials = Social::get()
            ->map(fn (Social $social) => [
                'id' => $social->id,
                'title' => $social->title,
                'link' => $social->link,
                'icon' => $social->icon,
            ])
            ->toArray();

        return response()->json($socials);
    }
}
