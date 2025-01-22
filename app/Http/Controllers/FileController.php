<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Response;

class FileController extends Controller
{
    public function show(File $file): Response
    {
        return response($file->getContent(), Response::HTTP_OK, [
            'Content-Type' => $file->mime_type,
        ]);
    }
}
