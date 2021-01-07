<?php


namespace Yousign\Domain\Data\UseCase;

use Yousign\Domain\Data\Presenter\ImportFromGhArchivePresenterInterface;
use Yousign\Domain\Data\Request\ImportFromGhArchiveRequest;
use Yousign\Domain\Data\Response\ImportFromGhArchiveResponse;
use Yousign\Domain\Data\Service\FileManagerInterface;
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
    private GitHubArchiveImporterServiceInterface $importer;

    /**
     * @var FileManagerInterface
     */
    private FileManagerInterface $fileManager;

    /**
     * ImportFromGhArchive constructor.
     * @param GitHubArchiveImporterServiceInterface $importer
     * @param FileManagerInterface $fileManager
     */
    public function __construct(
        GitHubArchiveImporterServiceInterface $importer,
        FileManagerInterface $fileManager
    ){
        $this->importer = $importer;
        $this->fileManager = $fileManager;
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
        $fileToManage = $fileManaged = 0;
        for($hour = 0;$hour <= 23;$hour++) {
            $fileToManage++;
            $this->importer->setHourToImport($hour);
            $fileName = $this->importer->getRemoteFileName();
            $this->fileManager->setFileName($fileName);
            $this->fileManager->downloadFile();
            $this->fileManager->extractFile();
            $this->fileManager->deleteFiles();
            $fileManaged++;
        }
        $presenter->present(new ImportFromGhArchiveResponse($date, $fileToManage, $fileManaged));
    }
}
