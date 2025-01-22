<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\File as FileFacade;

class File extends Model
{
    use HasFactory;

    public const MAIN_PICTURE = 'main_picture';

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

    public function documents(): MorphToMany
    {
        return $this->morphedByMany(Document::class, 'model', 'model_file')
            ->withPivot('file_role');
    }

    public function getContent(): ?string
    {
        $path = storage_path($this->storage_path);

        if (!FileFacade::exists($path)) {
            return null;
        }

        return FileFacade::get($path);
    }
}
