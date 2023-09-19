<?php

namespace App\User\Presentation\Http\Request;

class CreateUserDto
{
    public function __construct(
        public string $name,
        public string $password,
        public string $email,
        public string $biography,
    ) {
    }
}
