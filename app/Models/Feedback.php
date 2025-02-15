<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    public const FEEDBACK_ISSUE = 'issue';
    public const FEEDBACK_PRAISE = 'praise';
    public const FEEDBACK_SUGGESTION = 'suggestion';

    public const SUPPORTED_TYPES = [
        self::FEEDBACK_ISSUE,
        self::FEEDBACK_PRAISE,
        self::FEEDBACK_SUGGESTION,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'body',
        'data',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
