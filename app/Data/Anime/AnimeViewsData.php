<?php
namespace App\Data\Anime;

use Spatie\DataTransferObject\DataTransferObject;

class AnimeViewsData extends DataTransferObject
{
    public string $ip;

    public int $anime_id;
}
