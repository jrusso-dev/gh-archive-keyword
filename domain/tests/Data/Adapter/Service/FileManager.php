<?php


namespace Yousign\Domain\Tests\Data\Adapter\Service;

use SplFileObject;
use Yousign\Domain\Data\Service\FileManagerInterface;

/**
 * Class FileManager
 * @package Yousign\Domain\Tests\Data\Adapter\Service
 */

class FileManager implements FileManagerInterface
{
    const LOCAL_PATH = '/var/www/';
    const REMOTE_PATH = 'http://remote';
    /**
     * @var string
     */
    private string $fileName;

    /**
     * @return string
     */
    public function getLocalPath(): string
    {
        return self::LOCAL_PATH.$this->fileName;
    }

    /**
     * @return string
     */
    public function getRemotePath(): string
    {
        return self::REMOTE_PATH.$this->fileName;
    }

    /**
     * @return string
     */
    public function getDownloadExtension(): string
    {
        return '.json.gz';
    }

    /**
     * @return string
     */
    public function getFinalExtension(): string
    {
        return '.json';
    }

    /**
     * @param string $fileName
     */
    public function setBaseFileName(string $fileName): void
    {
        $this->fileName = $fileName;
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
     * @param string $destinationPath
     * @return void
     */
    public function extractFile(string $filePath, string $destinationPath): void
    {
        // TODO: Implement extractFile() method.
    }

    /**
     * @param string $filePath
     * @return SplFileObject
     */
    public function openFile(string $filePath): SplFileObject
    {
        return new SplFileObject('/');
    }

    /**
     * @param SplFileObject $file
     */
    public function setFileHandler(SplFileObject $file): void
    {
        // TODO: Implement setFileHandler() method.
    }

    /**
     * @param array $files
     * @return void
     */
    public function deleteFiles(array $files): void
    {
        // TODO: Implement deleteFiles() method.
    }

    /**
     * @param SplFileObject $file
     * @return void
     */
    public function deleteFile(SplFileObject $file): void
    {
        // TODO: Implement deleteFile() method.
    }
}
