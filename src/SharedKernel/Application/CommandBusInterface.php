<?php

declare(strict_types=1);

namespace App\SharedKernel\Application;

interface CommandBusInterface
{
    public function dispatch(object $command): void;
}
