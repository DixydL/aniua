<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimeEpisodeController extends Controller
{

    public function index(Anime $anime)
    {
        return new JsonResource($anime->episodes()->get());
    }

    public function store(Anime $anime, Request $request)
    {
        $episode = new Episode(
            [
                'name' => $request->name,
                'episode' => $request->episode,
                'iframe' => $request->iframe,
                'iframe2' => $request->iframe2,
                'iframe3' => $request->iframe3,
            ]
        );

        $anime->episodes()->save($episode);

        return new JsonResource($episode);
    }

    public function update(Anime $anime, Episode $episode, Request $request)
    {
        $episode->fill(
            [
                'name' => $request->name,
                'episode' => $request->episode,
                'iframe' => $request->iframe,
                'iframe2' => $request->iframe2,
                'iframe3' => $request->iframe3,
            ]
        );

        $episode->save();

        return new JsonResource($episode);
    }
}
