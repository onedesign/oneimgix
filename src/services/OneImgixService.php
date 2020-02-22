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
class OneImgixService extends Component
{
    private function getImgixDomain()
    {
        $source = Craft::parseEnv(OneImgix::getInstance()->getSettings()->sourceName);
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

    private function buildImgixUrl(Asset $asset, $params = [])
    {
        $imgixUrl = $this->getImgixDomain();
        $assetBaseUrl = $this->getAssetBaseUrl();
        $builder = new UrlBuilder($imgixUrl);
        $builder->setUseHttps(true);
        $filepath = str_replace($assetBaseUrl, '', $asset->url);
        $secureUrlToken = $this->getSecureUrlToken();

        if ('' != $secureUrlToken) {
            $builder->setSignKey($secureUrlToken);
        }
        return $builder->createURL($filepath, $params);
    }

    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    final public function url(Asset $asset, array $params = []): string
    {
        return $this->buildImgixUrl($asset, $params);
    }
}
