<?php
namespace App\DataRequest\Anime;

use Spatie\DataTransferObject\DataTransferObject;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class AnimeFilterDataRequest extends DataTransferObject
{
    /**
     * @OA\Property()
     */
    public string $search;

    /**
     * @OA\Property(
     *  type="array",
     *  @OA\Items(
     *    type="number"
     *  ),
     * )
     */
    public array $genres;
}
