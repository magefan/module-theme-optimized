<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Plugin\Magento\Framework\Css\PreProcessor\File;

use Magento\Framework\App\Area;
use Magento\Store\Model\App\Emulation;
use Magento\Framework\App\State;
use Magento\Framework\Css\PreProcessor\File\Temporary as FileTemporary;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\DesignInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory as ThemeCollectionFactory;

class Temporary
{


    /**
     * @var Emulation
     */
    private $emulation;

    /**
     * @var State
     */
    private $state;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ThemeCollectionFactory
     */
    private $themeCollectionFactory;

    /**
     * @var DesignInterface
     */
    private $design;

    /**
     * @var array|mixed
     */
    private $transferConfigProcessors;

    /**
     * @var
     */
    private $storeThemeMap;

    public function __construct(
        Emulation $emulation,
        State $state,
        StoreRepositoryInterface $storeRepository,
        ScopeConfigInterface $scopeConfig,
        ThemeCollectionFactory $themeCollectionFactory,
        DesignInterface $design,
        $transferConfigProcessors = []
    ) {
        $this->emulation = $emulation;
        $this->state = $state;
        $this->storeRepository = $storeRepository;
        $this->scopeConfig = $scopeConfig;
        $this->themeCollectionFactory = $themeCollectionFactory;
        $this->design = $design;
        $this->transferConfigProcessors = $transferConfigProcessors;
    }

    /**
     * @param FileTemporary $subject
     * @param $relativePath
     * @param $contents
     * @return array
     */
    public function beforeCreateFile(FileTemporary $subject, $relativePath, $contents): array
    {
        foreach ($this->transferConfigProcessors as $transferConfigProcessor) {
            if (strpos($relativePath, $transferConfigProcessor->getFileNameToProcess()) !== false) {
                $storeId = $this->getStoreIdByThemeFilePath($relativePath);
                $contents = $this->getFileContent($transferConfigProcessor, $storeId);
                break;
            }
        }

        return [$relativePath, $contents];
    }

    /**
     * @param $transferConfigProcessor
     * @param $storeId
     * @return string
     */
    private function getFileContent($transferConfigProcessor, ?int $storeId): string
    {
        /**
         * Fix grunt compile issue
         */
        try {
            $this->state->setAreaCode(Area::AREA_FRONTEND);
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            // do nothing
        }

        $this->emulation->startEnvironmentEmulation($storeId, Area::AREA_FRONTEND);
        $content = $transferConfigProcessor->process();
        $this->emulation->stopEnvironmentEmulation();

        return $content;
    }

    /**
     * @param string $themeFilePath
     * @return int|null
     */
    private function getStoreIdByThemeFilePath($themeFilePath): ?int
    {
        $pathParts = explode('/', $themeFilePath);
        $themePath = $pathParts[1] . '/' . $pathParts[2];

        if (!isset($this->storeThemeMap[$themePath])) {
            $themeId = $this->themeCollectionFactory->create()
                ->addFieldToFilter('theme_path', $themePath)
                ->getFirstItem()->getThemeId();

            $this->storeThemeMap[$themePath] = null;

            foreach ($this->storeRepository->getList() as $store) {
                $storeTheme = $this->scopeConfig->getValue(
                    DesignInterface::XML_PATH_THEME_ID,
                    ScopeInterface::SCOPE_STORE,
                    $store->getId()
                );

                if ($storeTheme == $themeId) {
                    $this->storeThemeMap[$themePath] = (int)$store->getId();
                    break;
                }
            }
        }

        return $this->storeThemeMap[$themePath];
    }
}
