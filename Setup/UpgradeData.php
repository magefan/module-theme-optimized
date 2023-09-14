<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Setup;

use Magento\Framework\Setup;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;
use Magento\Cms\Api\PageRepositoryInterface;

/**
 * Upgrade Data script
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var Setup\SampleData\Executor
     */
    protected $executor;

    /**
     * @var Updater
     */
    protected $updater;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var BlockFactory
     */
    protected $blockFactory;

    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var UrlRewriteCollectionFactory
     */
    protected $urlRewriteCollectionFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * UpgradeData constructor.
     * @param Setup\SampleData\Executor $executor
     * @param Updater $updater
     * @param PageFactory $pageFactory
     * @param BlockFactory $blockFactory
     * @param PageRepositoryInterface $pageRepository
     * @param UrlRewriteCollectionFactory $urlRewriteCollectionFactory
     * @param \Magento\Framework\App\State $state
     */
    public function __construct(
        Setup\SampleData\Executor $executor,
        Updater $updater,
        PageFactory $pageFactory,
        BlockFactory $blockFactory,
        PageRepositoryInterface $pageRepository,
        UrlRewriteCollectionFactory $urlRewriteCollectionFactory,
        \Magento\Framework\App\State $state
    ) {
        $this->executor = $executor;
        $this->updater = $updater;
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $blockFactory;
        $this->pageRepository = $pageRepository;
        $this->urlRewriteCollectionFactory = $urlRewriteCollectionFactory;
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        try {
            if (!$this->state->isAreaCodeEmulated()) {
                $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
            }
        } catch (\Exception $ex) {

        }

        if (version_compare($context->getVersion(), '1.1.1', '<')) {
            $this->updater->setCmsBlocksData('Magefan_ThemeOptimized::fixtures/blocks/blocks_1.1.1.csv');
            $this->updater->setCmsPagesData('Magefan_ThemeOptimized::fixtures/pages/pages_1.1.1.csv');
            $this->executor->exec($this->updater);
        }

        if (version_compare($context->getVersion(), '2.0.0', '<')) {
            $this->updater->setCmsBlocksData('Magefan_ThemeOptimized::fixtures/blocks/blocks_2.0.0.csv');
            $this->updater->setCmsPagesData('Magefan_ThemeOptimized::fixtures/pages/pages_2.0.0.csv');
            $this->executor->exec($this->updater);
        }


        $setup->endSetup();
    }
}
