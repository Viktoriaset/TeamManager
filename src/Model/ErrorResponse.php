<?php

namespace App\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use App\Model\ErrorDebugDetails;

class ErrorResponse
{
    public function __construct(private string $message, private mixed $detail = null)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @OA\Property(type="object", oneOf={
     *  @OA\Schema(ref=@Model(type=ErrorDebugDetails::class))
     * })
     */
    public function getDetail(): mixed
    {
        return $this->detail;
    }
}
