<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GlobalSearchByTagRequest;
use App\Http\Requests\IndexDocumentRequest;
use App\Http\Requests\IndexPostRequest;
use App\Http\Requests\IndexProjectRequest;
use App\Http\Resources\GlobalSearchByTagResource;
use App\Models\Tag;

class GlobalSearchController extends Controller
{
    public function searchByTags(GlobalSearchByTagRequest $request): GlobalSearchByTagResource
    {
        $validated = $request->validated();

        $tags = Tag::whereIn('name', $validated['tags'])->get();

        $documents = (new DocumentController())->index(new IndexDocumentRequest($validated));
        $posts = (new PostController())->index(new IndexPostRequest($validated));
        $projects = (new ProjectController())->index(new IndexProjectRequest($validated));

        return GlobalSearchByTagResource::make((object)[
            'documents' => $documents,
            'posts' => $posts,
            'projects' => $projects,
            'tags' => $tags,
        ]);
    }
}
