<?php

namespace App\User\Presentation\Http\Controller;

use App\SharedKernel\Application\CommandBusInterface;
use App\SharedKernel\Presentation\Http\ValidatorService;
use App\User\Application\Message\Command\CreateUser\CreateUserCommand;
use App\User\Presentation\Http\Constraint\CreateUserConstraint;
use App\User\Presentation\Http\Request\CreateUserDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/user', methods: 'POST')]
class CreateUserAction extends AbstractController
{
    private CommandBusInterface $commandBus;
    private ValidatorService $validatorService;

    public function __construct(CommandBusInterface $commandBus, ValidatorService $validatorService)
    {
        $this->commandBus = $commandBus;
        $this->validatorService = $validatorService;
    }

    public function __invoke(#[MapRequestPayload] CreateUserDto $createUserDto): JsonResponse
    {
        $this->validatorService->validate($createUserDto, CreateUserConstraint::class);

        $this->commandBus->dispatch(new CreateUserCommand(
            $createUserDto->name,
            $createUserDto->password,
            $createUserDto->email,
            $createUserDto->biography ?? ''
        ));

        return new JsonResponse(
            ['message' => 'OK']
        );
    }
}