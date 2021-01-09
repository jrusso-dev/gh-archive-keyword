<?php

namespace App\UserInterface\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiController
 * @package App\UserInterface\Controller
 */
class ApiController extends AbstractController
{
    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function returnBadRequest(string $message)
    {
        return $this->returnError(Response::HTTP_BAD_REQUEST, $message);
    }

    /**
     * @param int $errNo
     * @param string $message
     * @return JsonResponse
     */
    protected function returnError(int $errNo, string $message)
    {
        $error = ['code' => $errNo, 'message' => $message, 'content'  => null];
        return $this->json($error,$errNo);
    }

    /**
     * @param mixed $content
     * @param string $message
     * @return JsonResponse
     */
    protected function returnSuccess($content, string $message = '')
    {
        $code = Response::HTTP_OK;
        $response = ['code' => $code, 'message' => $message, 'content' => $content];
        return $this->json($response,$code);
    }

}
