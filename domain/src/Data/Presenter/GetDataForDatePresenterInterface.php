<?php


namespace Yousign\Domain\Data\Presenter;

use Yousign\Domain\Data\Response\GetDataForDateResponse;

/**
 * Interface GetDataForDatePresenterInterface
 * @package Yousign\Domain\Data\Presenter
 */
interface GetDataForDatePresenterInterface
{
    /**
     * @param GetDataForDateResponse $response
     */
    public function present(GetDataForDateResponse $response): void;
}
