<?php

namespace App\Subscriber;

use App\Service\ResponseManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ErrorSubscriber implements EventSubscriberInterface
{
    private $responseManager;

    /**
     * ErrorSubscriber constructor.
     *
     * @param $responseManager
     */
    public function __construct(ResponseManager $responseManager)
    {
        $this->responseManager = $responseManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::EXCEPTION => 'onDisplayError',
        ];
    }

    public function onDisplayError(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            'My Error says: %s',
            $exception->getMessage()

        );

        $response = new JsonResponse();
        $response->setContent($message);
        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);

        return $response;
    }
}
