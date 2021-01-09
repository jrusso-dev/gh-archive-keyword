<?php

namespace Yousign\Domain\Tests\Data;

use PHPUnit\Framework\TestCase;
use Yousign\Domain\Data\Presenter\GetDataForDatePresenterInterface;
use Yousign\Domain\Data\Request\GetDataForDateRequest;
use Yousign\Domain\Data\Response\GetDataForDateResponse;
use Yousign\Domain\Data\Response\ImportFromGhArchiveResponse;
use Yousign\Domain\Data\UseCase\GetDataForDate;

/**
 * Class GetDataForDateTest
 * @package Yousign\Domain\Tests\Data
 */
class GetDataForDateTest extends TestCase
{
    /**
     * @var GetDataForDate
     */
    private GetDataForDate $useCase;

    /**
     * @var GetDataForDatePresenterInterface
     */
    private GetDataForDatePresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class() implements GetDataForDatePresenterInterface
        {
            public ImportFromGhArchiveResponse $response;
            /**
             * @param GetDataForDateResponse $response
             */
            public function present(GetDataForDateResponse $response): void
            {
                $this->response = $response;
            }
        };


        $this->useCase = new GetDataForDate();
    }

    public function testSuccessful(): void
    {
        $date = new \DateTime("2020-12-01");
        $request = GetDataForDateRequest::create(
            $date,
            "love"
        );
        $this->assertEquals($date, $request->getDate());
        $this->assertEquals("love", $request->getKeyword());
    }



}
