<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class LayoutLoadBeforeObserver implements ObserverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        RequestInterface $request,
        ProductRepositoryInterface $productRepository
    ) {
        $this->request = $request;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->request->getFullActionName() == 'catalog_product_view') {
            $productId = $this->request->getParam('id');
            $product = $this->productRepository->getById($productId);

            if (!$product->getShortDescription()) {
                if (strlen($product->getDescription()) <= '700') {
                    $observer->getLayout()->getUpdate()->addHandle('move_catalog_product_view');
                }
            }
        }
    }
}
