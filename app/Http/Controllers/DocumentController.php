<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DocumentController extends Controller
{
    public function index(IndexDocumentRequest $request): AnonymousResourceCollection
    {
        $documents = Document::with('files')
            ->when(
                $request->has('tags'),
                fn (Builder $query) => $query->whereHas('tags', fn (Builder $query) => $query->whereIn('name', $request->tags), '=', count($request->tags)),
            )
            ->get();

        return DocumentResource::collection($documents);
    }

    public function show(Document $document): DocumentResource
    {
        return DocumentResource::make($document);
    }
}
