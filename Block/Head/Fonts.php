<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Block\Head;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magefan\ThemeOptimized\Model\Config;

class Fonts extends Template
{
    /**
     * @var string
     */
    protected $googlefontUrl = 'https://fonts.googleapis.com/css?display=swap&family=';

    /**
     * @var Config
     */
    protected $config;

    /**
     * Fonts constructor.
     * @param Context $context
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $config,
        array $data = []
    )
    {
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getGoogleFontUrl(): string
    {
        return $this->googlefontUrl . $this->config->getGoogleFont();
    }
}
