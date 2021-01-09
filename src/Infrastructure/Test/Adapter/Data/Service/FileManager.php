<?php


namespace App\Infrastructure\Test\Adapter\Data\Service;

use SplFileObject;
use Yousign\Domain\Data\Service\FileManagerInterface;

/**
 * Class FileManager
 * @package App\Infrastructure\Test\Adapter\Data\Service
 */
class FileManager implements FileManagerInterface
{

    /**
     * @return string
     */
    public function getDestinationFolder(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getLocalPath(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getRemotePath(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getDownloadExtension(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getFinalExtension(): string
    {
        return '';
    }

    /**
     * @param string $fileName
     */
    public function setBaseFileName(string $fileName): void
    {
        // TODO: Implement setBaseFileName() method.
    }

    /**
     * @param string $remotePath
     * @param string $destinationPath
     * @return void
     */
    public function downloadFile(string $remotePath, string $destinationPath): void
    {
        // TODO: Implement downloadFile() method.
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function extractFile(string $filePath): void
    {
        // TODO: Implement extractFile() method.
    }

    /**
     * @param string $filePath
     * @return SplFileObject
     */
    public function openFile(string $filePath): SplFileObject
    {
        return new SplFileObject($filePath);
    }

    /**
     * @param SplFileObject $file
     */
    public function setFileHandler(SplFileObject $file): void
    {
        // TODO: Implement setFileHandler() method.
    }

    /**
     * @param SplFileObject $file
     * @return string
     */
    public function getFileContent(SplFileObject $file): string
    {
        return '';
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function deleteFile(string $filePath): void
    {
        // TODO: Implement deleteFile() method.
    }
}
