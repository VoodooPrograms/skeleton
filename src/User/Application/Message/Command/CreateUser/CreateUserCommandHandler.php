<?php

namespace App\User\Application\Message\Command\CreateUser;

use App\SharedKernel\Domain\IdGeneratorInterface;
use App\User\Domain\User;
use App\User\Domain\UserRepositoryInterface;
use JetBrains\PhpStorm\NoReturn;
use Psr\Clock\ClockInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    private ClockInterface $clock;

    private IdGeneratorInterface $idGenerator;

    private PasswordHasherFactoryInterface $passwordHasher;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        ClockInterface $clock,
        IdGeneratorInterface $idGenerator,
        PasswordHasherFactoryInterface $passwordHasher,
        UserRepositoryInterface $userRepository
    ) {
        $this->clock = $clock;
        $this->idGenerator = $idGenerator;
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
    }

    #[NoReturn]
    public function __invoke(CreateUserCommand $createUserCommand): void
    {
//        if ($this->userRepository->findByEmail($createUserCommand->email) !== null) {
//            dd(11);
//            throw new UserDuplicationException();
//            throw new UserNotFoundException();
//        }

        // Generate uuid::v4 using generic service
        $uuid = $this->idGenerator->generate();

        // Hash password
        $hasher = $this->passwordHasher->getPasswordHasher('common');
        $hashedPassword = $hasher->hash($createUserCommand->password);

        // Add profile picture + get link
        $profilePictureLink = '';

        // Get current timestamp for registration date
        $registrationDateTime = $this->clock->now();

        $user = new User(
            $uuid,
            $createUserCommand->name,
            $createUserCommand->email,
            $hashedPassword,
            $profilePictureLink,
            $createUserCommand->biography,
            $registrationDateTime,
            null,
            null,
            $registrationDateTime,
            $registrationDateTime,
            $registrationDateTime,
        );
        $this->userRepository->store($user);
    }
}
