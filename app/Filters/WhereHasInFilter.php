<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class WhereHasInFilter extends BaseFilter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        $values = $this->request->get($this->requestAttribute, []);

        $query->when(
            count($values) > 0,
            fn (Builder $query) => $query
            ->whereHas(
                $this->requestAttribute,
                fn (Builder $query) => $query->when(
                    $this->isModelAttributeJson(),
                    fn (Builder $query) => $query->whereJsonContains($this->modelAttribute, $values),
                    fn (Builder $query) => $query->whereIn($this->modelAttribute, $values),
                ),
                '=',
                count($values),
            )
        );

        return $next($query);
    }
}
