<?php


namespace App\UserInterface\ViewModel;


use stdClass;
use Yousign\Domain\Data\Entity\Commit;
use Yousign\Domain\Data\Response\GetDataForDateResponse;

class GetDataForDateViewModel
{

    /**
     * @var string
     */
    public string $date;

    /**
     * @var string
     */
    public string $keyword;

    /**
     * @var int
     */
    public int $total = 0;

    /**
     * @var array
     */
    public array $dataByEventType = [];

    /**
     * @var array
     */
    public array $lastCommits = [];


    /**
     * @param GetDataForDateResponse $response
     * @return GetDataForDateViewModel
     */
    public static function fromResponse(GetDataForDateResponse $response): self
    {
        $model = new self();
        $model->date = $response->getDate()->format('Y-m-d');
        $model->keyword = $response->getKeyword();
        $model->dataByEventType = $response->getDataByEventType();
        $model->total = $response->getTotal();
        $model->lastCommits = array_map(
            fn (Commit $commit) => self::formatCommit($commit),
            $response->getLastCommits()
        );
        return $model;
    }

    /**
     * @param Commit $commit
     * @return stdClass
     */
    public static function formatCommit(Commit $commit): stdClass
    {
        $return = new stdClass();
        $return->repositoryName = $commit->getRepositoryName();
        $return->repositoryUrl = $commit->getRepositoryUrl();
        $return->message = $commit->getMessage();
        $return->commitId = $commit->getCommitId();
        return $return;
    }

}
