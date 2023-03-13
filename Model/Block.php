<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;
use Magento\Framework\Validator\Exception;
use Magento\Cms\Model\BlockFactory;

class Block
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
     * @var BlockFactory
     */
    protected $blockFactory;

    /**
     * @param SampleDataContext $sampleDataContext
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        BlockFactory $blockFactory
    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->blockFactory = $blockFactory;
    }

    /**
     * @param array $fixtures
     * @throws \Exception
     */
    public function install(array $fixtures)
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

                try {
                    $cmsBlock = $this->blockFactory->create();
                    $cmsBlock->getResource()->load($cmsBlock, $row['identifier']);

                    if (!$cmsBlock->getData()) {
                        $cmsBlock->setData($row);
                    } else {
                        $cmsBlock->addData($row);
                    }

                    $cmsBlock->setStores([\Magento\Store\Model\Store::DEFAULT_STORE_ID]);
                    $cmsBlock->save();
                } catch (\Exception $ex) {

                }
            }
        }
    }
}
