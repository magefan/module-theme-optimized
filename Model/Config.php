<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{

    const XML_PATH_TO_COLOR_SCHEME = 'mfthemefo/color_scheme/';

    const XML_PATH_TO_GALLERY_THUMBS_DIRECTION = 'mfthemefo/gallery/thumbs_direction';

    const XML_PATH_TO_GOOGLE_FONT_FAMILY = 'mfthemefo/google_font/google_font_family';

    const XML_PATH_TO_GOOGLE_FONT_WEIGHT = 'mfthemefo/google_font/google_font_weight';

    const XML_PATH_TO_GOOGLE_FONT_CHARACTER = 'mfthemefo/google_font/google_font_character';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $fieldName
     * @param null $storeId
     * @return string
     */
    public function getColorValue($fieldName, $storeId = null)
    {
        return (string)$this->getConfig(self::XML_PATH_TO_COLOR_SCHEME . $fieldName, $storeId);
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getGalleryThumbsDirection($storeId = null): string
    {
        return (string)$this->getConfig(self::XML_PATH_TO_GALLERY_THUMBS_DIRECTION, $storeId);
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getGoogleFont($storeId = null): string
    {
        return (string)$this->getConfig(self::XML_PATH_TO_GOOGLE_FONT_FAMILY, $storeId);
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getGoogleFontWeight($storeId = null): string
    {
        return (string)$this->getConfig(self::XML_PATH_TO_GOOGLE_FONT_WEIGHT, $storeId);
    }

    /**
     * @param null $storeId
     * @return array
     */
    public function getGoogleFontCharacter($storeId = null): array
    {
        return explode(',', (string)$this->getConfig(self::XML_PATH_TO_GOOGLE_FONT_CHARACTER, $storeId));
    }

    /**
     * Retrieve store config value
     * @param $path
     * @param null $storeId
     * @return mixed
     */
    public function getConfig($path, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
