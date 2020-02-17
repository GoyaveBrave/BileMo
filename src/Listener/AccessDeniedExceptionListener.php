<?php

namespace App\Listener;
use App\Exceptions\AccessDeniedException;
use App\Service\ResponseManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class AccessDeniedExceptionListener
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
            'My Error saysss: %s',
            $exception->getMessage()
        );
        $responder = $this->responseManager;
        if ($exception instanceof AccessDeniedException) {
            $data = ['error' => [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => $message
            ]
            ];
            $event->setResponse($responder($data, $event->getRequest(), Response::HTTP_FORBIDDEN));
        }
    }
}