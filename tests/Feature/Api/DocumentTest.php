<?php

namespace Tests\Feature\Api;

use App\Models\Document;
use App\Models\File;
use App\Models\Tag;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    private Document $documentWithoutRelations;
    private Document $documentWithImage;
    private Document $documentWithTag;
    private File $file;
    private Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now());

        $this->file = File::factory()->create();
        $this->tag = Tag::factory()->create([
            'name' => 'achievement',
            'translations' => [
                'en' => [
                    'achievement' => 'Achievement',
                ],
                'pl' => [
                    'achievement' => 'Osiągnięcie',
                ],
            ],
        ]);

        $this->documentWithoutRelations = Document::factory()->create();
        $this->documentWithImage = Document::factory()->create();
        $this->documentWithTag = Document::factory()->create();

        $this->documentWithImage->files()->save($this->file, [
            'file_role' => File::MAIN_PICTURE,
        ]);

        $this->documentWithTag->tags()->save($this->tag, [
            'order' => 0,
        ]);
    }

    private function getDocuments(array $query = []): TestResponse
    {
        return $this->getJson(url()->query('/api/documents', $query));
    }

    private function getDocument(string $slug): TestResponse
    {
        return $this->getJson('/api/documents/' . $slug);
    }

    public function test_all_documents_can_be_returned(): void
    {
        $response = $this->getDocuments();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'slug' => $this->documentWithoutRelations->slug,
                    'title' => $this->documentWithoutRelations->title,
                    'body' => $this->documentWithoutRelations->body,
                    'link' => $this->documentWithoutRelations->link,
                    'translations' => $this->documentWithoutRelations->translations,
                    'issuedAt' => $this->documentWithoutRelations->issued_at->diffForHumans() . ' (' . $this->documentWithoutRelations->issued_at->toDateString() . ')',
                    'image' => null,
                ],
                [
                    'slug' => $this->documentWithImage->slug,
                    'title' => $this->documentWithImage->title,
                    'body' => $this->documentWithImage->body,
                    'link' => $this->documentWithImage->link,
                    'translations' => $this->documentWithImage->translations,
                    'issuedAt' => $this->documentWithImage->issued_at->diffForHumans() . ' (' . $this->documentWithImage->issued_at->toDateString() . ')',
                    'image' => $this->documentWithImage->getMainPicture()->getUrl(),
                ],
                [
                    'slug' => $this->documentWithTag->slug,
                    'title' => $this->documentWithTag->title,
                    'body' => $this->documentWithTag->body,
                    'link' => $this->documentWithTag->link,
                    'translations' => $this->documentWithTag->translations,
                    'issuedAt' => $this->documentWithTag->issued_at->diffForHumans() . ' (' . $this->documentWithTag->issued_at->toDateString() . ')',
                    'image' => null,
                ],
            ],
        ]);
    }

    public function test_documents_can_be_filtered_by_tag(): void
    {
        $response = $this->getDocuments(['tags' => ['achievement']]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'slug' => $this->documentWithTag->slug,
                    'title' => $this->documentWithTag->title,
                    'body' => $this->documentWithTag->body,
                    'link' => $this->documentWithTag->link,
                    'translations' => $this->documentWithTag->translations,
                    'issuedAt' => $this->documentWithTag->issued_at->diffForHumans() . ' (' . $this->documentWithTag->issued_at->toDateString() . ')',
                    'image' => null,
                ],
            ],
        ]);
    }

    public function test_error_404_is_returned_when_document_does_not_exist(): void
    {
        $response = $this->getDocument('wrong');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_document_can_be_returned(): void
    {
        $response = $this->getDocument($this->documentWithImage->slug);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'slug' => $this->documentWithImage->slug,
                'title' => $this->documentWithImage->title,
                'body' => $this->documentWithImage->body,
                'link' => $this->documentWithImage->link,
                'translations' => $this->documentWithImage->translations,
                'issuedAt' => $this->documentWithImage->issued_at->diffForHumans() . ' (' . $this->documentWithImage->issued_at->toDateString() . ')',
                'image' => $this->documentWithImage->getMainPicture()->getUrl(),
            ],
        ]);
    }
}
