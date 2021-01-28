<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Anime as ResourcesAnime;
use App\Models\Anime;
use App\Models\Figure;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimeController extends Controller
{

    public function index(Request $request)
    {
        if ($request->search) {
            return ResourcesAnime::collection(Anime::where('name', 'like', '%'. $request->search .'%')
                ->orderBy("updated_at", "desc")
                ->get());
        }
        return ResourcesAnime::collection(Anime::orderBy("updated_at", "desc")->get());
    }

    public function relative()
    {
        return ResourcesAnime::collection(Anime::orderBy("updated_at", "desc")->limit(6)->get());
    }

    public function store(Request $request)
    {
        $anime = Anime::create(
            [
                'name' => $request->name,
                'name_origin' => $request->name_origin,
                'studio' => $request->studio,
                'description' => $request->description,
                'country' => $request->country,
                'type' => $request->type,
                'current_episodes' => (int)$request->current_episodes,
                'count_episodes' => $request->count_episodes,
                'poster_id' => $request->poster_id,
                'count_episodes' => 13,
                'release_date' => $request->release_date,
            ]
        );

        $this->setRelations($anime, $request);

        return new JsonResource($anime);
    }

    public function update(Anime $anime, Request $request)
    {
        $anime->fill(
            [
                'name' => $request->name,
                'name_origin' => $request->name_origin,
                'studio' => $request->studio,
                'description' => $request->description,
                'country' => $request->country,
                'type' => $request->type,
                'current_episodes' => $request->current_episodes,
                'poster_id' => $request->poster_id,
                'episodes' => $request->episodes,
                'release_date' => $request->release_date,
            ]
        );

        $anime->save();

        $this->setRelations($anime, $request);

        return new JsonResource($anime);
    }

    public function show(Anime $anime)
    {
        return new ResourcesAnime($anime);
    }

    public function setRelations($anime, $request)
    {
        $modelGenreIds = [];

        foreach ($request->genres as $genre) {
            $modelGenre = Genre::where(['name' => $genre])->first();

            if ($modelGenre === null) {
                $modelGenre = new Genre(
                    [
                        'name' => $genre,
                    ]
                );

                $modelGenre->save();
            }

            $modelGenreIds[] = $modelGenre->id;
        }

        $modelFigureIds = [];

        foreach ($request->voicers as $voicer) {
            $modelFigure = Figure::where(['name' => $voicer, 'type' => Figure::VOICER])->first();

            if ($modelFigure === null) {
                $modelFigure = new Figure(
                    [
                        'name' => $voicer,
                        'type' => Figure::VOICER,
                    ]
                );
                $modelFigure->save();
            }

            $modelFigureIds[] = $modelFigure->id;
        }

        foreach ($request->translators as $translator) {
            $modelFigure = Figure::where(['name' => $translator, 'type' => Figure::TRANSLATOR])->first();

            if ($modelFigure === null) {
                $modelFigure = new Figure(
                    [
                        'name' => $translator,
                        'type' => Figure::TRANSLATOR,
                    ]
                );
                $modelFigure->save();
            }

            $modelFigureIds[] = $modelFigure->id;
        }

        $anime->genres()->sync($modelGenreIds);
        $anime->figures()->sync($modelFigureIds);
    }
}
