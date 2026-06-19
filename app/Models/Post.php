<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Post extends Model implements Sitemapable
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

    public function toSitemapTag(): Url
    {
        $mainPicture = $this->getMainPicture();

        $url = Url::create('/blog/' . $this->slug)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setLastModificationDate($this->updated_at)
            ->setPriority(0.5);

        if ($mainPicture !== null) {
            $url->addImage(
                $mainPicture->getUrl(),
                Arr::get($this->translations, Lang::getFallback() . '.' . $this->title, $this->title),
            );
        }

        return $url;
    }
}
