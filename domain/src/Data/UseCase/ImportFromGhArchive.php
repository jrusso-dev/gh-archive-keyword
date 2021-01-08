<?php


namespace Yousign\Domain\Data\UseCase;

use Yousign\Domain\Data\Entity\Commit;
use Yousign\Domain\Data\Gateway\CommitGatewayInterface;
use Yousign\Domain\Data\Presenter\ImportFromGhArchivePresenterInterface;
use Yousign\Domain\Data\Request\ImportFromGhArchiveRequest;
use Yousign\Domain\Data\Response\ImportFromGhArchiveResponse;
use Yousign\Domain\Data\Service\EventParser\EventParserFactory;
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

        $rowsToManage = $rowManaged = 0;
        for ($hour = 0; $hour <= 23; $hour++) {
            $this->importer->setHourToImport($hour);
            $fileNameWithoutExtension = $this->importer->getRemoteFileName();
            $this->fileManager->setBaseFileName($fileNameWithoutExtension);
            $remotePath = $this->fileManager->getRemotePath();
            $localPath = $this->fileManager->getLocalPath();
            $localFolder = $this->fileManager->getDestinationFolder();
            $remoteExtension = $this->fileManager->getDownloadExtension();
            $localExtension = $this->fileManager->getFinalExtension();
            $this->fileManager->downloadFile($remotePath.$remoteExtension, $localFolder);
            $this->fileManager->extractFile($localPath.$remoteExtension);
            $file = $this->fileManager->openFile($localPath.$localExtension);
            while (!$file->eof()) {
                $commitDecoded = json_decode($file->fgets());
                if(isset($commitDecoded->type) && in_array($commitDecoded->type,Commit::EVENTS_TO_MANAGE)) {
                    /** @var EventParserFactory $eventParser */
                    $eventParser = EventParserFactory::fromEvent($commitDecoded);
                    $eventsParsed = $eventParser->getFormattedEvents();
                    foreach($eventsParsed as $eventParsed) {
                        $rowsToManage++;
                        $commit = Commit::fromObject($eventParsed);
                        $this->commitGateway->create($commit);
                        $rowManaged++;
                    }
                }
            }
            $file = null;
            $this->fileManager->deleteFile($localPath.$localExtension);
        }
        $presenter->present(new ImportFromGhArchiveResponse($date, $rowsToManage, $rowManaged));
    }
}
