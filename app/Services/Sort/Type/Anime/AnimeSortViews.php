<?php

namespace App\Services\Sort\Type\Anime;

use Illuminate\Database\Eloquent\Builder;

class AnimeSortUpdated implements AnimeSortInterface
{
    public Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function sort(string $by)
    {
        $this->query->orderBy('views', $by);
    }
}
