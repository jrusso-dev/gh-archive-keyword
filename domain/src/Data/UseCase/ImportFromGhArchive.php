<?php


namespace Yousign\Domain\Data\UseCase;

use Yousign\Domain\Data\Entity\Commit;
use Yousign\Domain\Data\Gateway\CommitGatewayInterface;
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
     * @var CommitGatewayInterface
     */
    private CommitGatewayInterface $commitGateway;

    /**
     * ImportFromGhArchive constructor.
     * @param GitHubArchiveImporterServiceInterface $importer
     * @param FileManagerInterface $fileManager
     * @param CommitGatewayInterface $commitGateway
     */
    public function __construct(
        GitHubArchiveImporterServiceInterface $importer,
        FileManagerInterface $fileManager,
        CommitGatewayInterface $commitGateway
    ) {
        $this->importer = $importer;
        $this->fileManager = $fileManager;
        $this->commitGateway = $commitGateway;
    }

    /**
     * @param ImportFromGhArchiveRequest $request
     * @param ImportFromGhArchivePresenterInterface $presenter
     */
    public function execute(ImportFromGhArchiveRequest $request, ImportFromGhArchivePresenterInterface $presenter)
    {
        $request->validate();
        $date = $request->getDate();
        $replaceData = $request->getReplaceData();
        $this->importer->setDateToImport($date);
        $commitsFromDate = $this->commitGateway->getCommitsForDate($date);
        if (count($commitsFromDate) > 0) {
            if (!$replaceData) {
                $presenter->present(
                    new ImportFromGhArchiveResponse($date, 0, 0)
                );
                return;
            }
            $this->commitGateway->removeCommitsFromDate($date);
        }

        $fileToManage = $fileManaged = 0;
        for ($hour = 0; $hour <= 23; $hour++) {
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
            $file = $this->fileManager->openFile($localPath.$localExtension);
            $jsonContent = $this->fileManager->getFileContent($file);
            $jsonLines = json_decode($jsonContent);
            foreach ($jsonLines as $commitDecoded) {
                $commit = Commit::fromObject($commitDecoded);
                $this->commitGateway->create($commit);
            }
            $fileManaged++;
        }
        $presenter->present(new ImportFromGhArchiveResponse($date, $fileToManage, $fileManaged));
    }
}
