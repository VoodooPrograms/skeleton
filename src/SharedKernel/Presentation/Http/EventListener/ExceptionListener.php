<?php

namespace App\SharedKernel\Presentation\Http\EventListener;

use App\SharedKernel\Presentation\Http\Exception\StatusCodeProviderInterface;
use App\SharedKernel\Presentation\Http\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\ConstraintViolationInterface;

final class ExceptionListener implements EventSubscriberInterface
{
    public function __construct(
        private string $environment
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();

        if ('json' === $request->getContentTypeFormat()) {
            $this->responseJson($event);
        }
    }

    private function responseJson(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$this->supportedException($exception)) {
            return;
        }

        $attribute = $this->getAttribute($exception);

        $response = new JsonResponse(
            data: $this->getErrorMessage($exception),
            status: $attribute->getStatusCode()
        );

        $event->setResponse($response);
    }

    private function getErrorMessage(\Throwable $exception): array
    {
        $error = [
            'error' => [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ],
        ];

        if ($exception instanceof ValidationException) {
            $constraints = [];
            /** @var ConstraintViolationInterface $result */
            //            dd($exception->getViolationList());
            foreach ($exception->getViolationList() as $result) {
                $constraints[$result->getPropertyPath()][] = $result->getMessage();
            }

            $error['error']['code'] = Response::HTTP_BAD_REQUEST;
            $error['error']['errors'] = $constraints;
        }

        if ('dev' === $this->environment) {
            $error = \array_merge(
                $error,
                [
                    'meta' => [
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'message' => $exception->getMessage(),
                        'trace' => $exception->getTrace(),
                        'traceString' => $exception->getTraceAsString(),
                    ],
                ]
            );
        }

        return $error;
    }

    private function getAttribute(\Throwable $exception): ?StatusCodeProviderInterface
    {
        $reflectionClass = new \ReflectionClass($exception);
        $attributes = $reflectionClass->getAttributes();

        $instances = array_map(
            fn (\ReflectionAttribute $attribute) => $attribute->newInstance(),
            $attributes
        );

        $supported = array_filter(
            $instances,
            fn (object $attribute) => $attribute instanceof StatusCodeProviderInterface
        );

        if (0 === count($supported)) {
            return null;
        }

        return $supported[array_key_first($supported)];
    }

    private function supportedException(\Throwable $exception): bool
    {
        return null !== $this->getAttribute($exception);
    }
}
