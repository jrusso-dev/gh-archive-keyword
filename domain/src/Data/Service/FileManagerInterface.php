<?php


namespace Yousign\Domain\Data\Service;

use SplFileObject;

/**
 * Interface FileManager
 * @package Yousign\Domain\Data\Service
 */
interface FileManagerInterface
{
    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void;

    /**
     * @return string
     */
    public function getRemoteFilePath(): string;

    /**
     * @return string
     */
    public function getLocalFilePath(): string;

    /**
     * @return bool
     */
    public function downloadFile(): bool;

    /**
     * @return bool
     */
    public function extractFile(): bool;

    /**
     * @return SplFileObject
     */
    public function openFile(): SplFileObject;

    /**
     * @return bool
     */
    public function deleteFiles(): bool;
}
