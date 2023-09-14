<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magefan\ThemeOptimized\Setup\Updater;
use Magento\Framework\Setup\SampleData\Executor;
use Magefan\ThemeOptimized\Model\Media;


class Theme_v_2_0_2 implements DataPatchInterface, PatchRevertableInterface
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
     * {@inheritdoc}
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

    public function revert()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [

        ];
    }
}
