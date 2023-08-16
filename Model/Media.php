<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem;

class Media
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var File
     */
    protected $fileDriver;

    /**
     * @param File $fileDriver
     * @param Filesystem $filesystem
     */
    public function __construct(
        File $fileDriver,
        Filesystem $filesystem,
    ) {
        $this->filesystem = $filesystem;
        $this->fileDriver = $fileDriver;
    }

    /**
     * @param string $fromPath
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function copyToPubMedia(string $fromPath): void
    {
        $root = $this->filesystem->getDirectoryRead(DirectoryList::ROOT)->getAbsolutePath();
        $fromPath = $this->fileDriver->getRelativePath($root, $fromPath);
        $baseName = basename($fromPath);

        $files = $this->filesystem->getDirectoryRead(DirectoryList::ROOT)->readRecursively($fromPath);

        foreach ($files as $file) {
            $newFileName = str_replace($fromPath, ltrim('/' . $baseName, '/'), $file);

            if ($this->fileDriver->isExists($newFileName)) {
                continue;
            }

            if ($this->fileDriver->isFile($file)) {
                $this->fileDriver->copy($file, $newFileName);
            } elseif ($this->fileDriver->isDirectory($file)) {
                $this->fileDriver->createDirectory($newFileName);
            }
        }
    }
}
