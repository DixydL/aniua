<?php
namespace App\DataRequest\Anime;

use Spatie\DataTransferObject\DataTransferObject;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class AnimeSortDataRequest extends DataTransferObject
{
    /**
     * @OA\Property(
     *    type="string",
     *    enum={"asc", "desc"},
     *    description="asc - По зменшенні, desc - по збільшенні"
     * )
     */
    public ?string $by;

    /**
     * @OA\Property(
     *    type="string",
     *    enum={"type_sort_updated", "type_sort_views"},
     *    description="type_sort_updated - сортурування по оновленях, type_sort_views - сортурування по переглядах"
     * )
     */
    public ?string $type;
}
