<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File as FileFacade;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'storage_path',
        'mime_type',
    ];

    public function getContent(): ?string
    {
        $path = storage_path($this->storage_path);

        if (!FileFacade::exists($path)) {
            return null;
        }

        return FileFacade::get($path);
    }
}
