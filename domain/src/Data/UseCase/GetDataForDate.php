<?php


namespace Yousign\Domain\Data\UseCase;

use Yousign\Domain\Data\Gateway\CommitGatewayInterface;
use Yousign\Domain\Data\Presenter\GetDataForDatePresenterInterface;
use Yousign\Domain\Data\Request\GetDataForDateRequest;
use Yousign\Domain\Data\Response\GetDataForDateResponse;

/**
 * Class GetDataForDate
 * @package Yousign\Domain\Data\UseCase
 */
class GetDataForDate
{

    /**
     * @var CommitGatewayInterface
     */
    private $commitGateway;

    /**
     * GetDataForDate constructor.
     * @param CommitGatewayInterface $commitGateway
     */
    public function __construct(
        CommitGatewayInterface $commitGateway
    ) {
        $this->commitGateway = $commitGateway;
    }

    /**
     * @param GetDataForDateRequest $request
     * @param GetDataForDatePresenterInterface $presenter
     */
    public function execute(GetDataForDateRequest $request, GetDataForDatePresenterInterface $presenter)
    {
        $request->validate();
        $date = $request->getDate();
        $keyword = $request->getKeyword();
        $lastCommits = $this->commitGateway->getLastCommitsForDate($date, 5, $keyword);
        $commitsForDate = $this->commitGateway->getCommitsForDateAndKeyword($date, $keyword);
        $response = new GetDataForDateResponse($date, $keyword);
        if(!empty($lastCommits)) {
            $response->setLastCommits($lastCommits);
        }
        if(!empty($commitsForDate)) {
            foreach($commitsForDate as $commit) {
                $hour = (int)$commit->getCreatedAt()->format('G');
                $eventType = $commit->getCommitType();
                $response->increaseDataForEventType($eventType, $hour);
            }
        }

        $presenter->present($response);
    }
}
