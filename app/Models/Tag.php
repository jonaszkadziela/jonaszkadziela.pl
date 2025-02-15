<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'translations',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'translations' => 'array',
        ];
    }

    public function documents(): MorphToMany
    {
        return $this->morphedByMany(Document::class, 'model', 'model_tag')
            ->withPivot('order');
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'model', 'model_tag')
            ->withPivot('order');
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'model', 'model_tag')
            ->withPivot('order');
    }
}
