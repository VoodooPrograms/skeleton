<?php

namespace App\SharedKernel\Infrastructure\Tools;

use App\SharedKernel\Domain\IdGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class IdGenerator implements IdGeneratorInterface
{
    public function generate(): Uuid
    {
        return self::generateStatic();
    }

    public static function generateStatic(): Uuid
    {
        return Uuid::v4();
    }
}