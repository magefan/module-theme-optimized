<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magefan\ThemeOptimized\CustomerData;

use Magento\Catalog\Model\Product\Image\NotLoadInfoImageException;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Wishlist\CustomerData\Wishlist as WishlistCustomerData;

/**
 * Wishlist section
 */
class Wishlist extends WishlistCustomerData
{

    /**
     * Create button label based on wishlist item quantity
     *
     * @param int $count
     * @return \Magento\Framework\Phrase|null
     */
    protected function createCounter($count)
    {
        if ($count > 1) {
            return __('%1', $count);
        } elseif ($count == 1) {
            return __('1');
        }
        return null;
    }
}
