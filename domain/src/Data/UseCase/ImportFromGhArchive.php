<?php


namespace Yousign\Domain\Data\UseCase;

use Yousign\Domain\Data\Presenter\ImportFromGhArchivePresenterInterface;
use Yousign\Domain\Data\Request\ImportFromGhArchiveRequest;
use Yousign\Domain\Data\Service\GitHubArchiveImporterServiceInterface;

/**
 * Class ImportFromGhArchive
 * @package Yousign\Domain\Data\UseCase
 */
class ImportFromGhArchive
{
    /**
     * @var GitHubArchiveImporterServiceInterface
     */
    private $importer;

    /**
     * ImportFromGhArchive constructor.
     * @param GitHubArchiveImporterServiceInterface $importer
     */
    public function __construct(
        GitHubArchiveImporterServiceInterface $importer
    ){
        $this->importer = $importer;
    }


    /**
     * @param ImportFromGhArchiveRequest $request
     * @param ImportFromGhArchivePresenterInterface $presenter
     */
    public function execute(ImportFromGhArchiveRequest $request, ImportFromGhArchivePresenterInterface $presenter)
    {
        $request->validate();
        $date = $request->getDate();
        $this->importer->setDateToImport($date);
        $fileName = [];
        for($hour = 1;$hour <= 23;$hour++) {
            $this->importer->setHourToImport($hour);
            $fileName[] = $this->importer->getRemoteFileName();
        }

        dd($fileName);


    }
}
