<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Genre as GenreAnime;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
    * @OA\Get(
    *  path="/api/genre",
    *  @OA\Response(
    *     response=200,
    *     description="successful operation",
    *     @OA\JsonContent(ref="#/components/schemas/GenreData"),
    *  )
    * )
    */
    public function index()
    {
        return GenreAnime::collection(Genre::orderBy("updated_at", "desc")->get());
    }
}
