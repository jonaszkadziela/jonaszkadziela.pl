<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function currentUser(): JsonResponse
    {
        $user = Auth::user();

        if ($user === null) {
            return response()->json();
        }

        return response()->json([
            'email' => $user->email,
            'isAdmin' => $user->is_admin,
            'name' => $user->name,
        ]);
    }
}
