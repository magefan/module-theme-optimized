<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class GoogleFontCharacter implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' =>  'cyrillic' , 'label' => 'Cyrillic' ],
            ['value' =>  'greek' ,     'label' => 'Greek'],
            ['value' =>  'khmer' ,      'label' => 'Khmer'],
            ['value' =>  'latin' ,      'label' => 'Latin'],
            ['value' =>  'vietnamese' , 'label' => 'Vietnamese'],
        ];
    }
}
