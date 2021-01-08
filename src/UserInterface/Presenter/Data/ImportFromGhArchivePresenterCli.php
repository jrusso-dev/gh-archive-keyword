<?php


namespace App\UserInterface\Presenter\Data;


use Yousign\Domain\Data\Presenter\ImportFromGhArchivePresenterInterface;
use Yousign\Domain\Data\Response\ImportFromGhArchiveResponse;

class ImportFromGhArchivePresenterCli implements ImportFromGhArchivePresenterInterface
{
    /**
     * @var ImportFromGhArchiveResponse
     */
    private ImportFromGhArchiveResponse $response;

    /**
     * @param ImportFromGhArchiveResponse $response
     */
    public function present(ImportFromGhArchiveResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        $response = $this->response;
        $date = $response->getDate()->format('Y-m-d');
        $nbRowsImported = $response->getNbRowsImported();
        return "$nbRowsImported row imported for date $date";
    }


}
