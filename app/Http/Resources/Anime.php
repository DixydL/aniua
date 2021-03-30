<?php

namespace App\Http\Resources;

use App\Models\Figure;
use Illuminate\Http\Resources\Json\JsonResource;

class Anime extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_origin' => $this->name_origin,
            'country' => $this->country,
            'type' => $this->type,
            'studio' => $this->studio,
            'count_episodes' => $this->count_episodes,
            'current_episodes' => $this->current_episodes,
            'release_date' => $this->release_date,
            'genres' => $this->genres,
            'episodes' => $this->episodes,
            'voicers' => $this->figures()->where('type', Figure::VOICER)->get(),
            'translators' => $this->figures()->where('type', Figure::TRANSLATOR)->get(),
            'views' => $this->countViews(),
            'season' => $this->season,
            'description' => $this->description,
            'poster_url' => $this->poster->url,
            'poster_id' => $this->poster_id,
        ];
    }
}
