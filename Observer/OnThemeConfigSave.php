<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Observer;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\State;
use Magento\Framework\Message\ManagerInterface as MessageManager;

class OnThemeConfigSave implements ObserverInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var State
     */
    private $state;

    /**
     * @var MessageManager
     */
    private $messageManager;

    /**
     * @param Filesystem $filesystem
     * @param MessageManager $messageManager
     * @param State $state
     */
    public function __construct(
        Filesystem $filesystem,
        MessageManager $messageManager,
        State $state
    ) {
        $this->filesystem = $filesystem;
        $this->messageManager = $messageManager;
        $this->state = $state;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->state->getMode() == State::MODE_DEVELOPER) {
            $staticDir = $this->filesystem->getDirectoryWrite(DirectoryList::STATIC_VIEW);
            $staticDir->delete('frontend/Magefan/optimized');

            $varDir = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
            $varDir->delete(DirectoryList::TMP_MATERIALIZATION_DIR . '/pub/static/frontend/Magefan/optimized');
            $this->messageManager->addNoticeMessage(__('Static Cache Clreared!'));
        } else {
            $this->messageManager->addNoticeMessage(__('Please run static content deploy to apply color changes!'));
        }
    }
}
