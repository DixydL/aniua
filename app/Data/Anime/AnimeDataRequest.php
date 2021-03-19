<?php

use Spatie\DataTransferObject\DataTransferObject;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class AnimeDataRequest extends DataTransferObject
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
