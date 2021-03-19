<?php
namespace App\Data\Anime;

use App\Models\Episode;
use Spatie\DataTransferObject\DataTransferObject;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class AnimeData extends DataTransferObject
{
    /** @OA\Property(
    *   property="id",
    *   type="number",
    *   description="Anime id"
    * )
    */
    public int $id;

    /** @OA\Property(
    *   property="name",
    *   type="string",
    *   description="Anime name"
    * )
    */
    public string $name;

    /**
    *  @OA\Property(
    *   property="name_origin",
    *   type="string",
    *   description="Anime name_origin"
    * )
    */
    public string $name_origin;

    /**
     * @OA\Property()
     */
    public string $description;

    /**
     * @OA\Property()
     */
    public string $country;

    /**
     * @OA\Property(
     *  type="array",
     *  @OA\Items(ref="#/components/schemas/EpisodeData")
     * )
     */
    public $episodes;

    /**
     * @OA\Property(
     *  type="array",
     *  @OA\Items(ref="#/components/schemas/GenreData")
     * )
     */
    public $genres;

    /**
     * @OA\Property()
     */
    public string $studio;

     /**
     * @OA\Property()
     */
    public string $type;

     /**
     * @OA\Property()
     */
    public int $current_episode;

     /**
     * @OA\Property()
     */
    public int $count_episodes;

     /**
     * @OA\Property()
     */
    public int $realese_date;

     /**
     * @OA\Property()
     */
    public int $views;

     /**
     * @OA\Property()
     */
    public int $season;
}
