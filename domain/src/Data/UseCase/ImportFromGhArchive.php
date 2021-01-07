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
            $fileNameWithoutExtension = $this->importer->getRemoteFileName();
            $this->fileManager->setBaseFileName($fileNameWithoutExtension);
            $remotePath = $this->fileManager->getRemotePath();
            $localPath = $this->fileManager->getLocalPath();
            $remoteExtension = $this->fileManager->getDownloadExtension();
            $localExtension = $this->fileManager->getFinalExtension();
            $this->fileManager->downloadFile($remotePath.$remoteExtension, $localPath.$remoteExtension);
            $this->fileManager->extractFile($localPath.$remoteExtension, $localPath.$localExtension);


            $fileManaged++;
        }
        $presenter->present(new ImportFromGhArchiveResponse($date, $fileToManage, $fileManaged));
    }
}
