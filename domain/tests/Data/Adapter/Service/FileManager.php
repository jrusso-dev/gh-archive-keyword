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
    const REMOTE_URL = 'https://remoteurl/';
    const LOCAL_FOLDER = '/tmp/';
    /**
     * @var string
     */
    private string $fileName;

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getRemoteFilePath(): string
    {
        return self::REMOTE_URL.$this->fileName;
    }

    /**
     * @return string
     */
    public function getLocalFilePath(): string
    {
        return self::LOCAL_FOLDER.$this->fileName;
    }

    /**
     * @return bool
     */
    public function downloadFile(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function extractFile(): bool
    {
        return true;
    }

    /**
     * @return SplFileObject
     */
    public function openFile(): SplFileObject
    {
        return new SplFileObject($this->getLocalFilePath());
    }

    /**
     * @return bool
     */
    public function deleteFiles(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}
