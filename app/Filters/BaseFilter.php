<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class BaseFilter
{
    protected string $modelAttribute;
    protected string $requestAttribute;

    public function __construct(protected Request $request, protected array $requestModelAttributeMap)
    {
        $this->requestAttribute = array_key_first($requestModelAttributeMap);
        $this->modelAttribute = $requestModelAttributeMap[$this->requestAttribute];
    }

    abstract public function handle(Builder $query, Closure $next): Builder;

    protected function isModelAttributeJson(): bool
    {
        return Str::contains($this->modelAttribute, '->');
    }
}
