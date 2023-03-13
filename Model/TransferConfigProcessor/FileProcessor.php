<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model\TransferConfigProcessor;

use Magento\Framework\Module\Dir\Reader as DirReader;
use Magento\Framework\Filesystem\Driver\File as FileReader;
use Magento\Framework\Filter\Template;

class FileProcessor
{
    const SAMPLE_DIR = 'Less';

    /**
     * @var Template
     */
    private $templateFilter;

    /**
     * @var FileReader
     */
    private $fileReader;

    /**
     * @var DirReader
     */
    private $moduleDirReader;

    public function __construct(
        Template $templateFilter,
        FileReader $fileReader,
        DirReader $moduleDirReader
    ) {
        $this->templateFilter = $templateFilter;
        $this->fileReader = $fileReader;
        $this->moduleDirReader = $moduleDirReader;
    }

    /**
     * Get styles config and put it into temporary file
     *
     * @param string $templateFile
     * @return string
     */
    public function processFile(string $templateFile): string
    {
        $pathToFileFolder = $this->moduleDirReader->getModuleDir('', 'Magefan_ThemeOptimized') . '/fixtures/less/';
        $content = $this->fileReader->fileGetContents($pathToFileFolder . $templateFile);
        $content = $this->templateFilter->filter($content);

        return $content;
    }
}
