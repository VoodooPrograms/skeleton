<?php

namespace App\SharedKernel\Presentation\Http\Exception;

interface StatusCodeProviderInterface
{
    public function getStatusCode(): int;
}
