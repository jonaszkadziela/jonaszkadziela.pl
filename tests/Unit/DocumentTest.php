<?php

namespace Tests\Unit;

use App\Models\Document;
use App\Models\File;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    private array $attributes;
    private Document $document;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'slug' => 'sample-document',
            'title' => 'Sample Document',
            'body' => 'sample-document-body',
            'link' => '/cv#certifications',
            'translations' => [
                'en' => [
                    'sample-document-body' => 'This is a sample document',
                ],
                'pl' => [
                    'sample-document-body' => 'To przykładowy dokument',
                ],
            ],
            'issued_at' => Carbon::parse('2024-11-01 12:00:00'),
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->document = Document::factory()->create($this->attributes);
    }

    public function test_document_attributes(): void
    {
        $this->assertSame($this->attributes['slug'], $this->document->slug);
        $this->assertSame($this->attributes['title'], $this->document->title);
        $this->assertSame($this->attributes['body'], $this->document->body);
        $this->assertSame($this->attributes['link'], $this->document->link);
        $this->assertSame($this->attributes['translations'], $this->document->translations);
        $this->assertTrue($this->attributes['issued_at']->equalTo($this->document->issued_at));
        $this->assertTrue($this->attributes['created_at']->equalTo($this->document->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->document->updated_at));
    }

    public function test_document_casts(): void
    {
        $this->assertTrue(getType($this->document->translations) === 'array');
        $this->assertTrue($this->document->issued_at instanceof Carbon);
        $this->assertTrue($this->document->created_at instanceof Carbon);
        $this->assertTrue($this->document->updated_at instanceof Carbon);
    }

    public function test_document_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->document)));
    }

    public function test_document_parent_classes(): void
    {
        $this->assertTrue($this->document instanceof Model);
    }

    public function test_document_files_relation(): void
    {
        $file = File::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $this->document->id,
                'model_type' => Document::class,
                'file_id' => $file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertTrue($this->document->files() instanceof MorphToMany);
        $this->assertCount(1, $this->document->files()->get());
        $this->assertSame($file->id, $this->document->files()->first()->id);
        $this->assertSame(File::MAIN_PICTURE, $this->document->files()->first()->pivot->file_role);
    }

    public function test_document_tags_relation(): void
    {
        $tag = Tag::factory()->create();

        DB::table('model_tag')
            ->insert([
                'model_id' => $this->document->id,
                'model_type' => Document::class,
                'tag_id' => $tag->id,
                'order' => 10,
            ]);

        $this->assertTrue($this->document->tags() instanceof MorphToMany);
        $this->assertCount(1, $this->document->tags()->get());
        $this->assertSame($tag->id, $this->document->tags()->first()->id);
        $this->assertSame(10, $this->document->tags()->first()->pivot->order);
    }

    public function test_document_get_main_picture_method(): void
    {
        $file = File::factory()->create();

        DB::table('model_file')
            ->insert([
                'model_id' => $this->document->id,
                'model_type' => Document::class,
                'file_id' => $file->id,
                'file_role' => File::MAIN_PICTURE,
            ]);

        $this->assertSame($file->id, $this->document->getMainPicture()->id);
    }
}
