<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'body',
        'link',
        'translations',
        'issued_at',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'issued_at' => 'datetime',
        ];
    }

    public function files(): MorphToMany
    {
        return $this->morphToMany(File::class, 'model', 'model_file')
            ->withPivot('file_role');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'model', 'model_tag')
            ->withPivot('order')
            ->orderByPivot('order');
    }

    public function getMainPicture(): ?File
    {
        return $this->files->where('pivot.file_role', '=', File::MAIN_PICTURE)->first();
    }
}
