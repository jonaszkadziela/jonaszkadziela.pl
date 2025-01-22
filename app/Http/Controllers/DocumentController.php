<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexDocumentRequest;
use App\Models\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    public function index(IndexDocumentRequest $request): JsonResponse
    {
        $documents = Document::with('files')
            ->when(
                $request->has('tags'),
                fn (Builder $query) => $query->whereHas('tags', fn (Builder $query) => $query->whereIn('name', $request->tags)),
            )
            ->get()
            ->map(function (Document $document) {
                $mainPicture = $document->getMainPicture();

                return [
                    'slug' => $document->slug,
                    'title' => $document->title,
                    'body' => $document->body,
                    'link' => $document->link,
                    'translations' => $document->translations ?? [],
                    'issuedAt' => $document->issued_at,
                    'image' => $mainPicture !== null ? secure_url('/files/' . $mainPicture->slug) : null,
                ];
            })
            ->toArray();

        return response()->json($documents);
    }
}
