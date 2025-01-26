<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::with(['files', 'tags'])
            ->get()
            ->map(fn (Project $project) => [
                'slug' => $project->slug,
                'title' => $project->title,
                'body' => $project->body,
                'link' => $project->link,
                'translations' => $project->translations ?? [],
                'isProBono' => $project->is_pro_bono,
                'tags' => $project->tags->map(fn (Tag $tag) => [
                    'name' => $tag->name,
                    'translations' => $tag->translations ?? [],
                ]),
                'image' => $project->getMainPicture()?->getUrl(),
                'route' => 'portfolio/' . $project->slug,
            ])
            ->toArray();

        return response()->json($projects);
    }
}
