<?php

namespace App\Subscriber;

use App\Service\ResponseManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
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
        $data = [
            'error' => [
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => $message,
            ],
        ];
        $responseManager = $this->responseManager;

        $event->setResponse($responseManager($data, $event->getRequest(), Response::HTTP_BAD_REQUEST));
    }
}
