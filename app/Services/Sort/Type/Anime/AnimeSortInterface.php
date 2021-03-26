<?php

namespace App\Services\Sort\Type\Anime;

use Illuminate\Database\Eloquent\Builder;

interface AnimeSortInterface
{
    public function __construct(Builder $query);

    public function sort(string $by);
}
