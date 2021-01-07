<?php


namespace Yousign\Domain\Data\Presenter;

use Yousign\Domain\Data\Response\ImportFromGhArchiveResponse;

/**
 * Interface ImportFromGhArchivePresenterInterface
 * @package Yousign\Domain\Data\Presenter
 */
interface ImportFromGhArchivePresenterInterface
{
    /**
     * @param ImportFromGhArchiveResponse $response
     */
    public function present(ImportFromGhArchiveResponse $response): void;
}
