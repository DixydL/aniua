<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Genre as GenreAnime;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        return GenreAnime::collection(Genre::orderBy("updated_at", "desc")->get());
    }

    public function update(){

    }
}
