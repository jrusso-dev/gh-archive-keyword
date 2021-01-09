<?php


namespace App\UserInterface\Presenter\Data;


use App\UserInterface\ViewModel\GetDataForDateViewModel;
use Yousign\Domain\Data\Presenter\GetDataForDatePresenterInterface;
use Yousign\Domain\Data\Response\GetDataForDateResponse;

/**
 * Class GetDataForDatePresenter
 * @package App\UserInterface\Presenter\Data
 */
class GetDataForDatePresenter implements GetDataForDatePresenterInterface
{

    /**
     * @var GetDataForDateViewModel
     */
    private GetDataForDateViewModel $response;

    /**
     * @param GetDataForDateResponse $response
     */
    public function present(GetDataForDateResponse $response): void
    {
        $this->response = GetDataForDateViewModel::fromResponse($response);
    }

    /**
     * @return GetDataForDateViewModel
     */
    public function getResponse(): GetDataForDateViewModel
    {
        return $this->response;
    }
}
