<?php

namespace Yousign\Domain\Tests\Data;

use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;
use Yousign\Domain\Data\Entity\Commit;
use Yousign\Domain\Data\Presenter\GetDataForDatePresenterInterface;
use Yousign\Domain\Data\Request\GetDataForDateRequest;
use Yousign\Domain\Data\Response\GetDataForDateResponse;
use Yousign\Domain\Data\UseCase\GetDataForDate;
use Yousign\Domain\Tests\Data\Adapter\Gateway\CommitGateway;

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
            public GetDataForDateResponse $response;
            /**
             * @param GetDataForDateResponse $response
             */
            public function present(GetDataForDateResponse $response): void
            {
                $this->response = $response;
            }
        };

        $commitGateway = new CommitGateway();

        $this->useCase = new GetDataForDate($commitGateway);
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
        $this->useCase->execute($request, $this->presenter);
        /** @var GetDataForDateResponse $response */
        $response = $this->presenter->response;
        $lastCommits = $response->getLastCommits();
        $dataByEventType = $response->getDataByEventType();
        $this->assertEquals($date, $response->getDate());
        $this->assertEquals("love", $response->getKeyword());
        $this->assertEquals(1, $response->getTotal());
        $this->assertEquals(1, count($lastCommits));
        $this->assertEquals('Lots of fun and lots of love', $lastCommits[0]->getMessage());
        $this->assertEquals('12345', $lastCommits[0]->getCommitId());
        $this->assertEquals('12345', $lastCommits[0]->getCommitId());
        $this->assertEquals(1, count($dataByEventType));
        $pushEvent = Commit::PUSH_EVT;
        $this->assertEquals(1, $dataByEventType[$pushEvent]->total);
        $this->assertEquals(1, $dataByEventType[$pushEvent]->{23});
    }

    public function testSuccessfulWithNoData(): void
    {
        $date = new \DateTime("2020-12-01");
        $request = GetDataForDateRequest::create(
            $date,
            "nodataforthiskeyword"
        );
        $this->assertEquals($date, $request->getDate());
        $this->assertEquals("nodataforthiskeyword", $request->getKeyword());
        $this->useCase->execute($request, $this->presenter);
        /** @var GetDataForDateResponse $response */
        $response = $this->presenter->response;
        $lastCommits = $response->getLastCommits();
        $dataByEventType = $response->getDataByEventType();
        $this->assertEquals($date, $response->getDate());
        $this->assertEquals("nodataforthiskeyword", $response->getKeyword());
        $this->assertEquals(0, $response->getTotal());
        $this->assertEquals(0, count($lastCommits));
        $this->assertEquals(0, count($dataByEventType));
    }

    public function testFailWithBlankKeyword(): void
    {
        $date = new \DateTime("2020-12-01");
        $request = GetDataForDateRequest::create($date, "");
        $this->expectException(AssertionFailedException::class);
        $this->useCase->execute($request, $this->presenter);
    }

    public function testFailWithTooShortKeyword(): void
    {
        $date = new \DateTime("2020-12-01");
        $request = GetDataForDateRequest::create($date, "key");
        $this->expectException(AssertionFailedException::class);
        $this->useCase->execute($request, $this->presenter);
    }



}
