<?php


namespace Yousign\Domain\Tests\Data;

use PHPUnit\Framework\TestCase;
use Yousign\Domain\Data\Presenter\ImportFromGhArchivePresenterInterface;
use Yousign\Domain\Data\Request\ImportFromGhArchiveRequest;
use Yousign\Domain\Data\Response\ImportFromGhArchiveResponse;
use Yousign\Domain\Data\UseCase\ImportFromGhArchive;
use Yousign\Domain\Tests\Data\Adapter\Gateway\CommitGateway;
use Yousign\Domain\Tests\Data\Adapter\Service\FileManager;
use Yousign\Domain\Tests\Data\Adapter\Service\ImporterService;

/**
 * Class ImportFromGhArchiveTest
 * @package Yousign\Domain\Tests\Data
 */
class ImportFromGhArchiveTest extends TestCase
{
    /**
     * @var ImportFromGhArchive
     */
    private ImportFromGhArchive $useCase;

    /**
     * @var ImportFromGhArchivePresenterInterface
     */
    private ImportFromGhArchivePresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class() implements ImportFromGhArchivePresenterInterface
        {
            public ImportFromGhArchiveResponse $response;
            /**
             * @param ImportFromGhArchiveResponse $response
             */
            public function present(ImportFromGhArchiveResponse $response): void
            {
                $this->response = $response;
            }
        };

        $importerService = new ImporterService();
        $fileManager = new FileManager();
        $commitGateway = new CommitGateway();

        $this->useCase = new ImportFromGhArchive($importerService, $fileManager, $commitGateway);
    }

    public function testSuccessful(): void
    {
        $request = ImportFromGhArchiveRequest::create(
            2020,
            12,
            31
        );
        $this->assertEquals(2020, $request->getYear());
        $this->assertEquals(12, $request->getMonth());
        $this->assertEquals(31, $request->getDay());
        $this->useCase->execute($request, $this->presenter);
        $this->assertInstanceOf(\DateTimeInterface::class, $this->presenter->response->getDate());
        $this->assertEquals(48, $this->presenter->response->getNbRowsToImport());
        $this->assertEquals(48, $this->presenter->response->getNbRowsImported());
    }

    public function testSuccessfulWithoutReplace(): void
    {
        $request = ImportFromGhArchiveRequest::create(
            2020,
            12,
            1
        );
        $this->assertEquals(2020, $request->getYear());
        $this->assertEquals(12, $request->getMonth());
        $this->assertEquals(1, $request->getDay());
        $this->useCase->execute($request, $this->presenter);
        $this->assertInstanceOf(\DateTimeInterface::class, $this->presenter->response->getDate());
        $this->assertEquals(0, $this->presenter->response->getNbRowsToImport());
        $this->assertEquals(0, $this->presenter->response->getNbRowsImported());
    }

}
