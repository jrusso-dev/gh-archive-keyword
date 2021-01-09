<?php


namespace Yousign\Domain\Data\UseCase;

use Yousign\Domain\Data\Presenter\GetDataForDatePresenterInterface;
use Yousign\Domain\Data\Request\GetDataForDateRequest;

/**
 * Class GetDataForDate
 * @package Yousign\Domain\Data\UseCase
 */
class GetDataForDate
{

    /**
     * @param GetDataForDateRequest $request
     * @param GetDataForDatePresenterInterface $presenter
     */
    public function execute(GetDataForDateRequest $request, GetDataForDatePresenterInterface $presenter)
    {
        $date = $request->getDate();
        $keyword = $request->getKeyword();
    }
}
