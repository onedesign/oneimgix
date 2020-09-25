<?php
/**
 * One Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with Imgix in Craft
 *
 * @link      https://onedesigncompany.com/
 * @copyright Copyright (c) 2020 One Design Company
 */

namespace onedesign\oneimgix\services;

use craft\awss3\Volume;
use craft\elements\Asset;
use Imgix\UrlBuilder;
use onedesign\oneimgix\OneImgix;

use Craft;
use craft\base\Component;

/**
 * @author    One Design Company
 * @package   OneImgix
 * @since     2.0.0
 */
class ImgixService extends Component
{
    /**
     * Imgix URL builder instance
     *
     * @var UrlBuilder|null
     */
    private $builder = null;

    private function getImgixDomain()
    {
        $source = Craft::parseEnv(OneImgix::getInstance()->getSettings()->sourceName);
        if (strpos($source, 'imgix.net')) {
            return $source;
        }
        return "${source}.imgix.net";
    }

    private function getApiKey()
    {
        return Craft::parseEnv(OneImgix::getInstance()->getSettings()->apiKey);
    }

    private function getAssetBaseUrl()
    {
        return Craft::parseEnv(OneImgix::getInstance()->getSettings()->assetBaseUrl);
    }

    private function getSecureUrlToken()
    {
        return Craft::parseEnv(OneImgix::getInstance()->getSettings()->secureUrlToken);
    }

    private function getBuilder()
    {
        if (!$this->builder) {
            $imgixUrl = $this->getImgixDomain();
            $secureUrlToken = $this->getSecureUrlToken();

            $this->builder = new UrlBuilder($imgixUrl, true, $secureUrlToken);
        }

        return $this->builder;
    }

    private function getFilePath(Asset $asset)
    {
        $assetVolume = $asset->getVolume();
        $assetPath = $asset->getPath();

        if ($assetVolume->subfolder ?? null) {
            $subfolder = $assetVolume->subfolder;
            return rtrim($subfolder, '/') . '/' . $assetPath;
        }

        return $assetPath;
    }

    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function url(Asset $asset, array $params = []): string
    {
        $builder = $this->getBuilder();
        $filepath = $this->getFilePath($asset);
        return $builder->createURL($filepath, $params);
    }

    public function srcSet(Asset $asset, array $params = [], array $options = [])
    {
        $builder = $this->getBuilder();
        $filepath = $this->getFilePath($asset);
        return $builder->createSrcSet($filepath, $params, $options);
    }
}
