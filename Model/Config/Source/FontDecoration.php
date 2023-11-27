<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class FontDecoration implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => 'none', 'value' => 'none',
            ],
            [
                'label' => 'underline', 'value' => 'underline',
            ],
            [
                'label' => 'overline', 'value' => 'overline',
            ],
            [
                'label' => 'line-through', 'value' => 'line-through',
            ],
            [
                'label' => 'initial', 'value' => 'initial',
            ],
            [
                'label' => 'inherit', 'value' => 'inherit',
            ]
        ];
    }
}
