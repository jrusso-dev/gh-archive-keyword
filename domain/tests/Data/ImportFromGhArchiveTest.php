<?php


namespace Yousign\Domain\Tests\Data;

use Assert\AssertionFailedException;
use Exception;
use Generator;
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
        $this->assertFalse($request->getReplaceData());
        $this->useCase->execute($request, $this->presenter);
        $this->assertInstanceOf(\DateTimeInterface::class, $this->presenter->response->getDate());
        $this->assertEquals(24, $this->presenter->response->getNbRowsToImport());
        $this->assertEquals(24, $this->presenter->response->getNbRowsImported());
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
        $this->assertFalse($request->getReplaceData());
        $this->useCase->execute($request, $this->presenter);
        $this->assertInstanceOf(\DateTimeInterface::class, $this->presenter->response->getDate());
        $this->assertEquals(0, $this->presenter->response->getNbRowsToImport());
        $this->assertEquals(0, $this->presenter->response->getNbRowsImported());
    }

    public function testSuccessfulWithReplace(): void
    {
        $request = ImportFromGhArchiveRequest::create(
            2020,
            12,
            1,
            true
        );
        $this->assertEquals(2020, $request->getYear());
        $this->assertEquals(12, $request->getMonth());
        $this->assertEquals(1, $request->getDay());
        $this->assertTrue($request->getReplaceData());
        $this->useCase->execute($request, $this->presenter);
        $this->assertInstanceOf(\DateTimeInterface::class, $this->presenter->response->getDate());
        $this->assertEquals(24, $this->presenter->response->getNbRowsToImport());
        $this->assertEquals(24, $this->presenter->response->getNbRowsImported());
    }

    public function testFailWithWrongDate(): void
    {
        $this->expectException(Exception::class);
        ImportFromGhArchiveRequest::create(
            2015,
            14,
            1
        );
    }

    /**
     * @dataProvider provideFailedRequestData
     * @param int $year
     * @param int $month
     * @param int $hour
     */
    public function testFailedRequest(
        int $year,
        int $month,
        int $hour
    ): void {
        $request = ImportFromGhArchiveRequest::create(
            $year,
            $month,
            $hour
        );
        $this->expectException(AssertionFailedException::class);
        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @return Generator
     */
    public function provideFailedRequestData(): Generator
    {
        yield [0, 0, 0];
        yield [2000, 1, 1];
        yield [2025, 10, 1];
    }

}
