<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

class Post extends Model
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
        'translations',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    /**
     * Filter posts that have the published_at attribute lower or equal to Carbon::now().
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    public function getMainPicture(): ?File
    {
        return $this->files->where('pivot.file_role', '=', File::MAIN_PICTURE)->first();
    }
}
