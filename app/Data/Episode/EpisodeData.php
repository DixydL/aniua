<?php
namespace App\Data\Genre;

use Spatie\DataTransferObject\DataTransferObject;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class EpisodeData extends DataTransferObject
{
    /** @OA\Property(
    *   property="id",
    *   type="number",
    *   description="Episode id"
    * )
    */
    public int $id;

    /** @OA\Property(
    *   property="name",
    *   type="string",
    *   description="Episode name"
    * )
    */
    public string $name;

    /**
     * @OA\Property()
     */
    public int $episode;

    /**
     * @OA\Property()
     */
    public string $iframe;
}
