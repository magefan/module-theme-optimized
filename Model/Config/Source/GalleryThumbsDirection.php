<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class GalleryThumbsDirection implements OptionSourceInterface
{

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
           [
               'label' => __('Vertical'),
               'value' => 'vertical'
           ],
           [
               'label' => __('Horizontal'),
               'value' => 'horizontal'
           ]
        ];
    }
}
