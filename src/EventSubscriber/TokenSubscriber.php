<?php

namespace App\EventSubscriber;

use App\Controller\TokenAuthenticatedController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    private $auth;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TokenAuthenticatedController) {
            $headers = $event->getRequest()->headers;
            if (!($headers->has('X-UserName') && $headers->get('X-UserName') == $this->auth['name'] &&
            $headers->has('X-Password') && hash('sha1', $headers->get('X-Password')) == hash('sha1', $this->auth['pass']))
            ) {
                throw new UnauthorizedHttpException('', 'Unauthorized');
            }
        }
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}