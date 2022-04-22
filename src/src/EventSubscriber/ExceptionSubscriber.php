<?php

namespace App\EventSubscriber;

use App\Services\SecurityToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $type = $event->getThrowable();

        $event->setResponse(new JsonResponse([
            'error' => 'true',
            'message' => $type->getMessage(),
        ]));
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
