<?php

namespace App\Listener;

use App\Exceptions\NotFoundException;
use App\Service\ResponseManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class NotFoundExceptionListener
{
    /**
     * @var ResponseManager
     */
    private $responseManager;

    /**
     * NotFoundExceptionListener constructor.
     */
    public function __construct(ResponseManager $responseManager)
    {
        $this->responseManager = $responseManager;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            'My Error says: %s',
            $exception->getMessage()
        );
        $responder = $this->responseManager;
        if ($exception instanceof NotFoundException) {
            $data = ['error' => [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => $message
            ]
        ];
            $event->setResponse($responder($data, $event->getRequest(), Response::HTTP_NOT_FOUND));
        }
    }
}
