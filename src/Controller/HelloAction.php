<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hello', name: 'hello', methods: 'GET')]
class HelloAction extends AbstractController
{
    public function __invoke(#[MapQueryParameter] string $name = 'Anonymous'): JsonResponse
    {
        return new JsonResponse(['message' => "Hello $name!"], Response::HTTP_OK);
    }
}
