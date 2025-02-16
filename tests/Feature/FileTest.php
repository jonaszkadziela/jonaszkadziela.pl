<?php

namespace Tests\Feature;

use App\Models\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class FileTest extends TestCase
{
    private File $file;
    private string $fileContent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->file = File::factory()->create();
        $this->fileContent = 'Sample file content';

        $path = storage_path($this->file->storage_path);

        FileFacade::spy();
        FileFacade::shouldReceive('exists')->with($path)->andReturn(true);
        FileFacade::shouldReceive('get')->with($path)->andReturn($this->fileContent);
    }

    private function getFile(string $slug): TestResponse
    {
        return $this->get('/files/' . $slug);
    }

    public function test_error_404_is_returned_when_file_does_not_exist(): void
    {
        $response = $this->getFile('wrong');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_file_can_be_returned(): void
    {
        $response = $this->getFile($this->file->slug);

        $response->assertOk();
        $response->assertContent($this->fileContent);
        $response->assertHeader('Content-Type');
    }
}
