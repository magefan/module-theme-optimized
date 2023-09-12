<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Plugin\Frontend\Magento;

class LeaveOnlyNumbers
{
    public function afterGetSectionData($subject, $result)
    {
        if (isset($result['countCaption'])) {
            $result['countCaption'] = preg_replace('/[^0-9]/', '', (string)$result['countCaption']);
        }

        if (isset($result['counter'])) {
            $result['counter'] = preg_replace('/[^0-9]/', '', (string)$result['counter']);
        }

        return $result;
    }
}
