<?php

namespace App\EventSubscriber;

use App\Services\SecurityToken;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $error = $event->getThrowable();
        $statusCode = null;

        if ($error instanceof HttpExceptionInterface) {
            $statusCode = $error->getStatusCode();
        } elseif ($error instanceof RequestExceptionInterface) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        if (null === $statusCode) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $event->setResponse(new JsonResponse([
            'error' => $statusCode,
            'error_description' => $error->getMessage(),
        ]));
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
