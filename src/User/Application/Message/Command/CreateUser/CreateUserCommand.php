<?php

namespace App\User\Application\Message\Command\CreateUser;

readonly class CreateUserCommand
{
    public function __construct(
        public string $name,
        public string $password,
        public string $email,
        public string $biography,
    ) {
    }
}