<?php

namespace App\Services;

use App\Data\Anime\AnimeViewsData;
use App\Models\AnimeView;
use Illuminate\Http\Request;

class AnimeService
{
    public function addAnimeViews(AnimeViewsData $animeViewsData)
    {
        if (AnimeView::where("anime_id", $animeViewsData->anime_id)
            ->where("ip", $animeViewsData->ip)
            ->exists()) {
            return;
        };

        $animeView = new AnimeView();
        $animeView->fill([
            'ip' => $animeViewsData->ip,
            'anime_id' => $animeViewsData->anime_id,
        ]);

        $animeView->save();
    }
}
