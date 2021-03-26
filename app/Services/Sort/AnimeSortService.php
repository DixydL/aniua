<?php

namespace App\Services\Sort;

use App\DataRequest\Anime\AnimeSortDataRequest;
use App\Enum\Anime\AnimeSortEnum;
use App\Services\Sort\Type\Anime\AnimeSortInterface;
use App\Services\Sort\Type\Anime\AnimeSortUpdated;
use App\Services\Sort\Type\Anime\AnimeSortViews;

class AnimeSortService
{
    public function animeSort($query, AnimeSortDataRequest $sort)
    {
        $class = $this->getList()[$sort->type];

        (new $class($query))->sort($sort->by);
    }

    /**
     *
     * @return array|AnimeSortInterface[]
     */
    public function getList(): array
    {
        return [
            AnimeSortEnum::TYPE_SORT_UPDATED => AnimeSortUpdated::class,
            AnimeSortEnum::TYPE_SORT_VIEWS => AnimeSortViews::class,
        ];
    }
}
