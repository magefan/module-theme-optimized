<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class GoogleFontWeights implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => '300', 'value' => '400',
            ],
            [
                'label' => '400', 'value' => '400',
            ],
            [
                'label' => '500', 'value' => '600',
            ],
            [
                'label' => '600', 'value' => '600',
            ],
            [
                'label' => '700', 'value' => '600',
            ],
            [
                'label' => '800', 'value' => '600',
            ],
            [
                'label' => '900', 'value' => '600',
            ],
        ];
    }
}
