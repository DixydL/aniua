<?php
namespace App\Data\Genre;

use Spatie\DataTransferObject\DataTransferObject;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class GenreData extends DataTransferObject
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
}
