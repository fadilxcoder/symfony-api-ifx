<?php

namespace App\EventSubscriber;

use App\Services\SecurityToken;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ClientHeaderSubscriber implements EventSubscriberInterface
{
    private $securityToken;

    public function __construct(SecurityToken $securityToken)
    {
        $this->securityToken = $securityToken;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if ($event->getRequest()->getRequestUri() === '/') {
            return;
        }

        if (null === $event->getRequest()->headers->get('X-Client')) {
            $event->setResponse(new JsonResponse([
                'error' => 'true',
                'message' => 'X-Client missing !'
            ]));
        }

        if ($event->getRequest()->headers->get('x-client') !== $this->securityToken->getToken()) {
            $event->setResponse(new JsonResponse([
                'error' => 'true',
                'message' => 'Invalid X-Client token !'
            ]));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
