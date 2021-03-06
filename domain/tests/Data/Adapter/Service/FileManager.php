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
        return new SplFileObject(__DIR__.'/../../Fixtures/eventsFixture.json');
    }

    /**
     * @param SplFileObject $file
     */
    public function setFileHandler(SplFileObject $file): void
    {
        // TODO: Implement setFileHandler() method.
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function deleteFile(string $filePath): void
    {
        // TODO: Implement deleteFile() method.
    }

    /**
     * @param SplFileObject $file
     * @return string
     */
    public function getFileContent(SplFileObject $file): string
    {
        $content = [
            [
                "id" => "12345",
                "type" => "CreatedEvent",
                "repo" => [
                    "name" => "test/test",
                    "url" => "http://github/test/test"
                ],
                "payload" => [
                    "description" => "Super description"
                ],
                "created_at" => "2020-12-31T15:00:00Z"
            ],
            [
                "id" => "12345",
                "type" => "CreatedEvent",
                "repo" => [
                    "name" => "test/test",
                    "url" => "http://github/test/test"
                ],
                "payload" => [
                    "description" => "Super description"
                ],
                "created_at" => "2020-12-31T16:00:00Z"
            ]
        ];

        return json_encode($content);
    }


}
