<?php

namespace App\SharedKernel\Presentation\Http\Exception\Status;

use App\SharedKernel\Presentation\Http\Exception\StatusCodeProviderInterface;
use Attribute;
use Symfony\Component\HttpFoundation\Response;

#[Attribute(Attribute::TARGET_CLASS)]
class ForbiddenAccess implements StatusCodeProviderInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
