<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class WhereLikeFilter extends BaseFilter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        $query->where($this->attribute, 'LIKE', '%' . $this->request->get($this->attribute) . '%');

        return $next($query);
    }
}
