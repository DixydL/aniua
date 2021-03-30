<?php

namespace App\Services;

use App\Data\Anime\AnimeViewsData;
use App\Models\AnimeView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimeService
{
    public function addAnimeViews(AnimeViewsData $animeViewsData)
    {
        if (AnimeView::where("anime_id", $animeViewsData->anime_id)
            ->where("ip", $animeViewsData->ip)
            ->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 HOUR)'))
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
