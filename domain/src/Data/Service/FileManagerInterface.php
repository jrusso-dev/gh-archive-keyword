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
     * @return string
     */
    public function getLocalPath(): string;

    /**
     * @return string
     */
    public function getRemotePath(): string;

    /**
     * @return string
     */
    public function getDownloadExtension(): string;

    /**
     * @return string
     */
    public function getFinalExtension(): string;

    /**
     * @param string $fileName
     */
    public function setBaseFileName(string $fileName): void;

    /**
     * @param string $remotePath
     * @param string $destinationPath
     * @return void
     */
    public function downloadFile(string $remotePath, string $destinationPath): void;

    /**
     * @param string $filePath
     * @param string $destinationPath
     * @return void
     */
    public function extractFile(string $filePath, string $destinationPath): void;

    /**
     * @param string $filePath
     * @return SplFileObject
     */
    public function openFile(string $filePath): SplFileObject;

    /**
     * @param SplFileObject $file
     */
    public function setFileHandler(SplFileObject $file) :void;

    /**
     * @param SplFileObject $file
     * @return string
     */
    public function getFileContent(SplFileObject $file) :string;

    /**
     * @param string $filePath
     * @return void
     */
    public function deleteFile(string $filePath): void;
}
