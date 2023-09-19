<?php

namespace App\User\Domain;

interface UserRepositoryInterface
{
    public function store(User $user): void;

    public function find(string $uuid): ?User;

    public function findByEmail(string $email): ?User;
}
