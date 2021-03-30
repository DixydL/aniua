<?php

namespace App\Services\Sort\Type\Anime;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AnimeSortViews implements AnimeSortInterface
{
    public Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function sort(string $by)
    {
      //  $this->query->select(DB::raw('anime_views.count_views as views'));
        $this->query->withCount('views');
        //dd($this->query->get());
        $this->query->orderBy('views_count', $by);
    }
}
