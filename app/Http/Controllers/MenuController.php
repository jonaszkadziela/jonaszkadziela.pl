<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $menus = Menu::get();

        return MenuResource::collection($menus);
    }
}
