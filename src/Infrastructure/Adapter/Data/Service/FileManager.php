<?php


namespace App\Infrastructure\Adapter\Data\Service;

use SplFileObject;
use Yousign\Domain\Data\Service\FileManagerInterface;
use function json_encode;

/**
 * Class FileManager
 * @package App\Infrastructure\Adapter\Data\Service
 */
class FileManager implements FileManagerInterface
{
    const LOCAL_PATH = '/tmp/';
    const REMOTE_PATH = 'https://data.gharchive.org/';
    /**
     * @var string
     */
    private string $fileName;

    /**
     * @return string
     */
    public function getDestinationFolder(): string
    {
        return self::LOCAL_PATH;
    }

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
        exec("wget $remotePath -P $destinationPath");
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function extractFile(string $filePath): void
    {
        exec("gzip -d $filePath");
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
        return "";
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function deleteFile(string $filePath): void
    {
        unlink($filePath);
    }
}
