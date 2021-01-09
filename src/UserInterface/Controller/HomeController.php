<?php


namespace App\UserInterface\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class HomeController
 * @package App\UserInterface\Controller
 */
class HomeController extends ApiController
{

    /**
     * @Route("/", name="home_route", methods={"GET"})
     * @return JsonResponse
     */
    public function home(): JsonResponse
    {
        return $this->returnSuccess('Welcome to the API');
    }
}
