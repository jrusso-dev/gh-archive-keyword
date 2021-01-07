<?php


namespace Yousign\Domain\Data\Service;

use SplFileObject;

/**
 * Interface FileManager
 * @package Yousign\Domain\Data\Service
 */
interface FileManager
{
    /**
     * @param string $path
     */
    public function setFilePath(string $path): void;

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
    public function deleteFile(): bool;
}
