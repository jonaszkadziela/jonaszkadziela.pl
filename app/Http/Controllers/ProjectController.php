<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(IndexProjectRequest $request): AnonymousResourceCollection
    {
        $projects = Project::with(['files', 'tags'])
            ->when(
                $request->has('tags'),
                fn (Builder $query) => $query->whereHas('tags', fn (Builder $query) => $query->whereIn('name', $request->tags), '=', count($request->tags)),
            )
            ->orderByRaw('-`finished_at`')
            ->get();

        return ProjectResource::collection($projects);
    }

    public function show(Project $project): ProjectResource
    {
        $project->load(['files', 'tags']);

        return ProjectResource::make($project);
    }
}
