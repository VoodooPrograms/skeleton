<?php

namespace App\SharedKernel\Infrastructure\Application;

use App\SharedKernel\Application\CommandBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements CommandBusInterface
{
    private MessageBusInterface $messageBus;

    private EntityManagerInterface $entityManager;

    public function __construct(
        MessageBusInterface $messageBus,
        EntityManagerInterface $entityManager
    ) {
        $this->messageBus = $messageBus;
        $this->entityManager = $entityManager;
    }

    public function dispatch(object $command): void
    {
        try {
            $this->entityManager->getConnection()->beginTransaction();
            $this->messageBus->dispatch($command);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (HandlerFailedException $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e->getPrevious();
            //            $this->throwException($e);
        }
    }
}
