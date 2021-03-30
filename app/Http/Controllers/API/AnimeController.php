<?php

namespace App\Http\Controllers\API;

use App\Data\Anime\AnimeViewsData;
use App\DataRequest\Anime\AnimeFilterDataRequest;
use App\DataRequest\Anime\AnimeSortDataRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Anime as ResourcesAnime;
use App\Models\Anime;
use App\Models\Figure;
use App\Models\Genre;
use App\Services\AnimeService;
use App\Services\Sort\AnimeSortService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimeController extends Controller
{

    /**
    * @OA\Get(
    *  path="/api/anime",
    *  @OA\Parameter(
    *       name="filter",
    *       in="query",
    *       description="filter",
    *       @OA\Schema(ref="#/components/schemas/AnimeFilterDataRequest")
    *  ),
    *  @OA\Parameter(
    *       name="sort",
    *       in="query",
    *       description="sort",
    *       @OA\Schema(ref="#/components/schemas/AnimeSortDataRequest")
    *  ),
    *  @OA\Response(
    *     response=200,
    *     description="successful operation",
    *     @OA\JsonContent(
    *        type="array",
    *        @OA\Items(ref="#/components/schemas/AnimeData")
    *     ),
    *  )
    * )
    */
    public function index(Request $request, AnimeSortService $animeSortService)
    {
        $query = Anime::query();

        if ($request->filter) {
            $animeFilterDataRequest = new AnimeFilterDataRequest([
                'search' => $request->filter['search'] ?? "",
                'genres' => $request->filter['genres'] ?? [],
                'season' => $request->filter['season'] ?? null,
            ]);

            if ($animeFilterDataRequest->search) {
                $query = $query->where('name', 'like', '%'. $request->search .'%');
            }

            if ($animeFilterDataRequest->genres) {
                $genres = $request->genres;
                $query = $query->whereHas('genres', function ($genreQuery) use ($genres) {
                    $genreQuery->whereIn('name', $genres);
                });
            }

            if ($animeFilterDataRequest->season) {
                $query = $query->where('season', $animeFilterDataRequest->season);
            }
        }

        if ($request->sort) {
            $animeSortDataRequest = new AnimeSortDataRequest([
                'type' => $request->sort['type'] ?? "",
                'by' => $request->sort['by'] ?? [],
            ]);

            $animeSortService->animeSort($query, $animeSortDataRequest);
        }

        if ($query) {
            return ResourcesAnime::collection($query->orderBy("updated_at", "desc")
                ->get());
        }

        return ResourcesAnime::collection(Anime::orderBy("updated_at", "desc")->get());
    }

    /**
    * @OA\Get(
    *  path="/api/anime/relative",
    *  @OA\Response(
    *     response=200,
    *     description="successful operation",
    *     @OA\JsonContent(
    *        type="array",
    *        @OA\Items(ref="#/components/schemas/AnimeData")
    *     ),
    *  )
    * )
    */
    public function relative()
    {
        return ResourcesAnime::collection(Anime::orderBy("updated_at", "desc")->limit(6)->get());
    }

    /**
    * @OA\Post(
    *  path="/api/anime",
    *  @OA\Response(
    *     response=200,
    *     description="successful operation",
    *     @OA\JsonContent(ref="#/components/schemas/AnimeData"),
    *  )
    * )
    */
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
                'season' => (int)$request->season,
                'current_episodes' => (int)$request->current_episodes,
                'count_episodes' => (int)$request->count_episodes,
                'poster_id' => (int)$request->poster_id,
                'release_date' => (int)$request->release_date,
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
                'season' => (int)$request->season,
                'current_episodes' => (int)$request->current_episodes,
                'count_episodes' => (int)$request->count_episodes,
                'poster_id' => (int)$request->poster_id,
                'release_date' => (int)$request->release_date,
            ]
        );

        $anime->save();

        $this->setRelations($anime, $request);

        return new JsonResource($anime);
    }

    /**
    * @OA\Get(
    *  path="/api/anime/{id}",
    *  @OA\Parameter(
    *    description="ID anime",
    *    in="path",
    *    name="id",
    *    required=true,
    *    @OA\Schema(
    *       type="integer",
    *       format="int64"
    *      )
    *  ),
    *  @OA\Response(
    *     response=200,
    *     description="successful operation",
    *     @OA\JsonContent(ref="#/components/schemas/AnimeData"),
    *  )
    * )
    */
    public function show(Request $request, Anime $anime, AnimeService $animeService)
    {
        $animeViewData = new AnimeViewsData([
            "ip" => $request->ip(),
            "anime_id" => $anime->id,
        ]);

        $animeService->addAnimeViews($animeViewData);
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
