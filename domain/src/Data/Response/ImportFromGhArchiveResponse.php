<?php


namespace Yousign\Domain\Data\Response;

/**
 * Class ImportFromGhArchiveResponse
 * @package Yousign\Domain\Data\Response
 */
class ImportFromGhArchiveResponse
{
    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $date;

    /**
     * @var int
     */
    private int $nbRowsToImport;

    /**
     * @var int
     */
    private int $nbRowsImported;


    public function __construct(
        \DateTimeInterface $date,
        int $nbRowsToImport,
        int $nbRowsImported
    ) {
        $this->date = $date;
        $this->nbRowsToImport = $nbRowsToImport;
        $this->nbRowsImported = $nbRowsImported;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getNbRowsToImport(): int
    {
        return $this->nbRowsToImport;
    }

    /**
     * @return int
     */
    public function getNbRowsImported(): int
    {
        return $this->nbRowsImported;
    }

}
