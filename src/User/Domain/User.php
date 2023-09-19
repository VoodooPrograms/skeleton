<?php

namespace App\User\Domain;

use App\SharedKernel\Infrastructure\Tools\IdGenerator;
use Symfony\Component\Uid\Uuid;

class User
{
    private Uuid $uuid;

    public function __construct(
        ?Uuid $uuid,
        private string $name,
        private string $email,
        private string $password,
        private ?string $profilePictureLink = null,
        private string $biography = '',
        private \DateTimeImmutable $registrationDate,
        private ?\DateTimeImmutable $lastLoginDate = null,
        private ?\DateTimeImmutable $verifiedDate = null,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
        private ?\DateTimeImmutable $deletedAt = null
    ) {
        $this->uuid = $uuid ?? IdGenerator::generateStatic();
    }
}