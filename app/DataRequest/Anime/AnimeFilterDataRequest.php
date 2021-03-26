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
    public ?string $search;

    /**
     * @OA\Property(
     *  type="array",
     *  @OA\Items(
     *    type="number"
     *  ),
     * )
     */
    public ?array $genres;

    /**
     * @OA\Property(
     *    type="number",
     *    enum={"0", "1", "2", "3", "4"},
     *    description="0 - без сезону, 1 - Весна, 2 - Літо, 3 - Осінь, 4 - Зима"
     * )
     */
    public ?int $season;
}
