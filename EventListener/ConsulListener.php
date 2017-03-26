<?php

namespace ConsulBundle\EventListener;

use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\Exception\ConsulExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ConsulListener
{
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $controllerResult = $event->getControllerResult();
        if (!$controllerResult instanceof ConsulResponse) {
            return;
        }

        $response = new Response($controllerResult->getBody(), $controllerResult->getStatusCode(), $controllerResult->getHeaders());
        $response->headers->remove('Transfer-Encoding');

        $event->setResponse($response);
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if (!$exception instanceof ConsulExceptionInterface) {
            return;
        }

        $response = new Response($exception->getMessage(), $exception->getCode());

        $event->setResponse($response);
    }
}
