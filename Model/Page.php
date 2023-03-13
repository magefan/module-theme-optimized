<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;
use Magento\Cms\Model\PageFactory;

class Page
{
    /**
     * @var \Magento\Framework\Setup\SampleData\FixtureManager
     */
    private $fixtureManager;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvReader;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @param SampleDataContext $sampleDataContext
     * @param PageFactory $pageFactory
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        PageFactory $pageFactory
    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->pageFactory = $pageFactory;
    }

    /**
     * @param array $fixtures
     * @param mixed $sliderId
     * @param mixed $blockId
     * @throws \Exception
     */
    public function install(array $fixtures, $blockId = [])
    {
        foreach ($fixtures as $fileName) {
            $fileName = $this->fixtureManager->getFixture($fileName);

            if (!file_exists($fileName)) {
                continue;
            }

            $rows = $this->csvReader->getData($fileName);
            $header = array_shift($rows);

            foreach ($rows as $row) {
                $data = [];

                foreach ($row as $key => $value) {
                    $data[$header[$key]] = $value;
                }

                $row = $data;

                $this->pageFactory->create()->load($row['identifier'], 'identifier')
                    ->addData($row)
                    ->setStores([\Magento\Store\Model\Store::DEFAULT_STORE_ID])
                    ->save();
            }
        }
    }
}
