<?php

namespace App\Http\Controllers;

use App\Filters\WhereHasInFilter;
use App\Filters\WhereLikeFilter;
use App\Http\Requests\IndexPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Pipeline;

class PostController extends Controller
{
    public function index(IndexPostRequest $request): AnonymousResourceCollection
    {
        $query = Post::with(['files', 'tags']);

        $posts = Pipeline::send($query)
            ->through([
                new WhereLikeFilter($request, 'title'),
                new WhereHasInFilter($request, 'name', 'tags'),
            ])
            ->thenReturn()
            ->get();

        return PostResource::collection($posts);
    }
}
