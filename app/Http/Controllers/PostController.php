<?php

namespace App\Http\Controllers;

use App\Filters\WhereHasInFilter;
use App\Filters\WhereLikeFilter;
use App\Http\Requests\IndexPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(IndexPostRequest $request): AnonymousResourceCollection
    {
        $query = Post::with(['files', 'tags']);
        $locale = Lang::getLocale();

        $posts = Pipeline::send($query)
            ->through([
                new WhereLikeFilter($request, [
                    'title' => 'translations->' . $locale . '->title',
                ]),
                new WhereHasInFilter($request, [
                    'tags' => 'name',
                ]),
            ])
            ->thenReturn()
            ->get()
            ->map(function (Post $post) {
                $post->translations = collect($post->translations)
                    ->map(fn (array $translations) => array_replace($translations, [
                        'body' => Str::limit(Arr::get($translations, 'body', ''), 250),
                    ]))
                    ->toArray();

                return $post;
            });

        return PostResource::collection($posts);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function show(string $slugWithId): PostResource
    {
        $post = Post::with(['files', 'tags'])
            ->where('id', '=', Str::afterLast($slugWithId, '-'))
            ->firstOrFail();

        return PostResource::make($post);
    }
}
