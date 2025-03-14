<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function currentUser(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user === null) {
            return response()->json();
        }

        return response()->json([
            'avatar' => $user->getAvatar(),
            'email' => $user->email,
            'isAdmin' => $user->is_admin,
            'name' => $user->name,
        ]);
    }
}
