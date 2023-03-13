<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Setup;

use Magento\Framework\Setup;
use Magefan\ThemeOptimized\Model\Page;
use Magefan\ThemeOptimized\Model\Block;

class Installer implements Setup\SampleData\InstallerInterface
{

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Block
     */
    private $block;

    /**
     * @param Page $page
     * @param Block $block
     */
    public function __construct(
        Page $page,
        Block $block
    ) {
        $this->page = $page;
        $this->block = $block;
    }

    /**
     * @throws \Exception
     */
    public function install()
    {
        $this->page->install(['Magefan_ThemeOptimized::fixtures/pages/pages.csv']);
        $this->block->install(['Magefan_ThemeOptimized::fixtures/blocks/blocks.csv']);
    }
}
