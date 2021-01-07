<?php


namespace App\Controller;

use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home_route", methods={"GET"})
     * @return JsonResponse
     */
    public function home(): JsonResponse
    {
        //Home
        return $this->json('Welcome to my API');

    }
}
