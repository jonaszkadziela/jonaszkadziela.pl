<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WhereHasInFilter extends BaseFilter
{
    public function __construct(Request $request, string $attribute, protected string $relation)
    {
        parent::__construct($request, $attribute);
    }

    public function handle(Builder $query, Closure $next): Builder
    {
        $values = $this->request->get($this->relation, []);

        $query->when(
            count($values) > 0,
            fn (Builder $query) => $query
            ->whereHas(
                $this->relation,
                fn (Builder $query) => $query->whereIn($this->attribute, $values),
            )
        );

        return $next($query);
    }
}
