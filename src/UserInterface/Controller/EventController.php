<?php


namespace App\UserInterface\Controller;

use App\UserInterface\Presenter\Data\GetDataForDatePresenter;
use Assert\AssertionFailedException;
use Exception;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yousign\Domain\Data\Request\GetDataForDateRequest;
use Yousign\Domain\Data\UseCase\GetDataForDate;

/**
 * Class HomeController
 * @package App\UserInterface\Controller
 */
class EventController extends ApiController
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
        $date = $request->get('date');
        $keyword = $request->get('keyword');
        if(!$date) {
            return $this->returnBadRequest('Missing parameter date');
        }
        if(!$keyword) {
            return $this->returnBadRequest('Missing parameter keyword');
        }
        $dateForRequest = new \DateTime($date);

        $getDataForDateRequest = GetDataForDateRequest::create($dateForRequest, $keyword);
        $presenter = new GetDataForDatePresenter();

        try {
            $getDataForDate->execute($getDataForDateRequest, $presenter);
        }catch (AssertionFailedException $exception) {
            return $this->returnBadRequest('You must set a valid date and keyword');
        }catch (Exception $exception) {
            return $this->returnBadRequest($exception->getMessage());
        }

        $response = $presenter->getResponse();
        return $this->returnSuccess($response);
    }
}
