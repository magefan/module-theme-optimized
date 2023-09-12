<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\ViewModel;

use Magefan\ThemeOptimized\Model\Config;

class GalleryHelper implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * @param string $galleryImagesJson
     * @param int $thumbsCount
     * @return array
     */
    public function getPreparedThumbs(string $galleryImagesJson, int $thumbsCount): array
    {
        $j = 1;
        $thumbs = [];

        foreach (json_decode($galleryImagesJson, true) as $thumbImages) {
            if ($j > $thumbsCount) {
                break;
            }

            $thumb = [
                'alt' => $thumbImages['caption'],
                'videoUrl' => $thumbImages['videoUrl']
            ];

            $j++;

            $webPUrl = $thumbImages['thumb'];

            if (strpos($webPUrl, 'mf_webp') === false) {
                $thumb['src'] = $thumbImages['thumb'];
                $thumbs[] = $thumb;
                continue;
            }

            $array = explode('/', $webPUrl);
            $imageFormat = '';

            for ($i = 0; $i < count($array); $i++) {
                if ($array[$i] == "mf_webp") {
                    $imageFormat = $array[$i + 1];
                    array_splice($array, $i, 3);
                    break;
                }
            }

            $imageUrl = implode('/', $array);

            $thumb['src'] = str_replace('.webp', '.' . $imageFormat, $imageUrl);

            $thumbs[] = $thumb;
        }

        return $thumbs;
    }

    /**
     * @return string
     */
    public function getThumbsDirection(): string
    {
        return $this->config->getGalleryThumbsDirection();
    }
}
