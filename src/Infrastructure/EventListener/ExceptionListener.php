<?php
namespace App\Infrastructure\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class ExceptionListener
 * @package App\Infrastructure\EventListener
 */
class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * ExceptionListener constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $code = $exception->getCode();
        if($code === 0) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();
        }

        $message = $exception->getMessage();
        $this->logger->critical($message);

        // create json response and set the nice message from exception
        $customResponse = new JsonResponse(['code'=>$code, 'message' => $message],$code);

        // set it as response and it will be sent
        $event->setResponse($customResponse);
    }
}
