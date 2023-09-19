<?php

namespace App\User\Infrastructure\Repository;

use App\User\Domain\User;
use App\User\Domain\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function store(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function find(string $uuid): ?User
    {
        return $this->entityManager->find(User::class, $uuid);
    }

    public function findByEmail(string $email): ?User
    {
        $repository = $this->entityManager->getRepository(User::class);

        return $repository->findOneBy(['email' => $email]);
    }
}
