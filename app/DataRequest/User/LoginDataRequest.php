<?php
namespace App\DataRequest\Anime;

use Spatie\DataTransferObject\DataTransferObject;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class LoginDataRequest extends DataTransferObject
{

    /**
     * @OA\Property()
     */
    public string $email;

    /**
     * @OA\Property()
     */
    public string $password;
}
