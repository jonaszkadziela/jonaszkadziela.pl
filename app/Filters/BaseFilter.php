<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BaseFilter
{
    public function __construct(protected Request $request, protected string $attribute)
    {
    }

    abstract public function handle(Builder $query, Closure $next): Builder;
}
