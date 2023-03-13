<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model\TransferConfigProcessor;

use Magefan\ThemeOptimized\Model\ConfigProvider;

class Color
{
    const OUTPUT_LESS_FILE = 'css/source/variables/_fo_theme_colors.less';
    const TEMPLATE_FILE = '_fo_theme_colors.template';

    /**
     * @var FileProcessor
     */
    private $fileProcessor;

    public function __construct(
        FileProcessor $fileProcessor
    ) {
        $this->fileProcessor = $fileProcessor;
    }

    /**
     * Process styles config
     *
     * @return string
     */
    public function process(): string
    {
        return $this->fileProcessor->processFile(self::TEMPLATE_FILE);
    }

    /**
     * @return string
     */
    public function getFileNameToProcess(): string
    {
        return self::OUTPUT_LESS_FILE;
    }

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isValidToProcess(?int $storeId): bool
    {
        return true;
    }
}
