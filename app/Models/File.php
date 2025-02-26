<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

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
        'storage_disk',
        'storage_path',
        'mime_type',
    ];

    public function documents(): MorphToMany
    {
        return $this->morphedByMany(Document::class, 'model', 'model_file')
            ->withPivot('file_role');
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'model', 'model_file')
            ->withPivot('file_role');
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'model', 'model_file')
            ->withPivot('file_role');
    }

    public function getContent(): ?string
    {
        if (!Storage::disk($this->storage_disk)->exists($this->storage_path)) {
            return null;
        }

        return Storage::disk($this->storage_disk)->get($this->storage_path);
    }

    public function getUrl(): string
    {
        return secure_url('/files/' . $this->slug);
    }

    /**
     * The FileUpload component from Filament expects filenames to be stored as an array.
     * So, we need to grab the first value from the array to avoid array to string conversion issues.
     */
    protected function storagePath(): Attribute
    {
        return Attribute::make(
            set: fn (mixed $value) => is_array($value) ? Arr::first($value) : $value,
        );
    }
}
