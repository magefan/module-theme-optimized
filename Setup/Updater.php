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

class Updater implements Setup\SampleData\InstallerInterface
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
     * @var array
     */
    private $cmsPagesData = [];

    /**
     * @var array
     */
    private $cmsBlocksData = [];

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
     * @param string $pagesCsv
     * @return $this
     */
    public function setCmsPagesData(string $pagesCsv)
    {
        array_push($this->cmsPagesData, $pagesCsv);
        return $this;
    }

    /**
     * @param string $blockCsv
     * @return $this
     */
    public function setCmsBlocksData(string $blockCsv)
    {
        array_push($this->cmsBlocksData, $blockCsv);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        if (count($this->cmsPagesData)) {
            $this->page->install($this->cmsPagesData);
            $this->cmsPagesData = [];
        }

        if (count($this->cmsBlocksData)) {
            $this->block->install($this->cmsBlocksData);
            $this->cmsBlocksData = [];
        }
    }
}
