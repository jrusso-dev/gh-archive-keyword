<?php


namespace App\UserInterface\Controller;

use App\UserInterface\Presenter\Data\GetDataForDatePresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yousign\Domain\Data\Request\GetDataForDateRequest;
use Yousign\Domain\Data\UseCase\GetDataForDate;

/**
 * Class HomeController
 * @package App\UserInterface\Controller
 */
class EventController extends AbstractController
{

    /**
     * @Route("/event", name="event_route", methods={"POST"})
     * @param Request $request
     * @param GetDataForDate $getDataForDate
     * @return JsonResponse
     * @throws \Exception
     */
    public function getDataForDate(
        Request $request,
        GetDataForDate $getDataForDate
    ): JsonResponse
    {
        $date = new \DateTime('2020-10-01');
        $keyword = "test";

        $getDataForDateRequest = GetDataForDateRequest::create($date, $keyword);
        $presenter = new GetDataForDatePresenter();

        $getDataForDate->execute($getDataForDateRequest, $presenter);

        return $this->json('Fetch the response with the ViewModel pattern');

    }
}
