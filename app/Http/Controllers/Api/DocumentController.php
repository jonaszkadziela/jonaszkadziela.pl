<?php

namespace App\Http\Controllers\Api;

use App\Filters\WhereHasInFilter;
use App\Filters\WhereLikeFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Pipeline;

class DocumentController extends Controller
{
    public function index(IndexDocumentRequest $request): AnonymousResourceCollection
    {
        $locale = Lang::getLocale();
        $query = Document::with('files');

        $documents = Pipeline::send($query)
            ->through([
                new WhereLikeFilter($request, [
                    'title' => 'translations->' . $locale . '->title',
                ]),
                new WhereLikeFilter($request, [
                    'body' => 'translations->' . $locale . '->body',
                ]),
                new WhereHasInFilter($request, [
                    'tags' => 'name',
                ]),
            ])
            ->thenReturn()
            ->get();

        return DocumentResource::collection($documents);
    }

    public function show(Document $document): DocumentResource
    {
        return DocumentResource::make($document);
    }
}
