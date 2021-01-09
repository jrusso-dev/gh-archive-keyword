<?php


namespace App\UserInterface\Presenter\Data;


use Yousign\Domain\Data\Presenter\GetDataForDatePresenterInterface;
use Yousign\Domain\Data\Response\GetDataForDateResponse;

/**
 * Class GetDataForDatePresenter
 * @package App\UserInterface\Presenter\Data
 */
class GetDataForDatePresenter implements GetDataForDatePresenterInterface
{

    /**
     * @var GetDataForDateResponse
     */
    private GetDataForDateResponse $response;

    /**
     * @param GetDataForDateResponse $response
     */
    public function present(GetDataForDateResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return GetDataForDateResponse
     */
    public function getResponse(): GetDataForDateResponse
    {
        return $this->response;
    }
}
