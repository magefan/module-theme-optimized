<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magefan\ThemeOptimized\Setup\Updater;
use Magento\Framework\Setup\SampleData\Executor;
use Magefan\ThemeOptimized\Model\Media;


class PrepareSampleData implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Updater
     */
    private $updater;

    /**
     * @var Executor
     */
    private $executor;

    /**
     * @var Media
     */
    private $media;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param Updater $updater
     * @param Executor $executor
     * @param Media $media
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        Updater $updater,
        Executor $executor,
        Media $media
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->executor = $executor;
        $this->updater = $updater;
        $this->media = $media;
    }

    /**
     * @return void
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->updater->setCmsBlocksData('Magefan_ThemeOptimized::fixtures/blocks/blocks_2.0.2.csv');
        $this->updater->setCmsPagesData('Magefan_ThemeOptimized::fixtures/pages/pages_2.0.2.csv');
        $this->executor->exec($this->updater);

        $this->updateMediaFiles();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function updateMediaFiles()
    {
        $this->media->copyToPubMedia(__DIR__ . '/../../../pub');
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }
}
