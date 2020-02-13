<?php

namespace App\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Contracts\EventDispatcher\Event;

class ExceptionListener extends Event
{
    const NAME = 'exception.event';

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        $response = new Response();
        $response->setContent($message);
    }
}
