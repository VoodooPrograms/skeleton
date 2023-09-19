<?php

namespace App\SharedKernel\Domain;

use Symfony\Component\Uid\Uuid;

interface IdGeneratorInterface
{
    public function generate(): Uuid;

    public static function generateStatic(): Uuid;
}