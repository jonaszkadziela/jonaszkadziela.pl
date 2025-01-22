<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        $menus = Menu::get()
            ->map(fn (Menu $menu) => [
                'name' => $menu->name,
                'route' => $menu->route,
                'translations' => $menu->translations ?? [],
            ])
            ->toArray();

        return response()->json($menus);
    }
}
