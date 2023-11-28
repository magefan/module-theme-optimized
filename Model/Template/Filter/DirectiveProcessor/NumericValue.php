<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model\Template\Filter\DirectiveProcessor;

use Magefan\ThemeOptimized\Model\Config;
use Magento\Framework\Filter\DirectiveProcessorInterface;
use Magento\Framework\Filter\Template;

class NumericValue implements DirectiveProcessorInterface
{
    const REGULAR_EXPRESSION_TO_GET_COLOR_VARIABLE_NAME  = '/{{numeric_value\s\(([a-z\_\/]{0,100})\)}}/si';

    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param array $construction
     * @param Template $filter
     * @param array $templateVariables
     * @return string
     */
    public function process(array $construction, Template $filter, array $templateVariables): string
    {
        $value = $this->config->getConfig($construction[1]);

        return ($value ?  $value : '1') . $this->addPrefix($construction[1]);
    }

    /**
     * @return string
     */
    public function getRegularExpression(): string
    {
        return self::REGULAR_EXPRESSION_TO_GET_COLOR_VARIABLE_NAME;
    }

    /**
     * @param $configPath
     * @return string
     */
    protected function addPrefix($configPath): string
    {
        $withOutPixel = ['mfthemefo/default_button/button_font_weight'];

        return in_array($configPath, $withOutPixel) ? '' : 'px';
    }
}
