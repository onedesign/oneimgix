<?php
/**
 * One Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with Imgix in Craft
 *
 * @link      https://onedesigncompany.com/
 * @copyright Copyright (c) 2020 One Design Company
 */

namespace onedesign\oneimgix\variables;

use craft\elements\Asset;
use onedesign\oneimgix\OneImgix;

use Craft;

/**
 * @author    One Design Company
 * @package   OneImgix
 * @since     2.0.0
 */
class OneImgixVariable
{
    /**
     * Return an imgix URL for an asset
     *
     * @param Asset|null $asset
     * @param array $params
     * @return string
     */
    public function url($asset = null, array $params = []): string
    {
        if (!$asset) {
            return '';
        }
        return OneImgix::$plugin->imgix->url($asset, $params);
    }

    /**
     * Return a string of srcset values for an asset. Passes params and options directly to Imgix
     *
     * @link https://github.com/imgix/imgix-php#srcset-generation
     *
     * @param Asset|null $asset
     * @param array $params
     * @param array $options
     * @return string
     */
    public function srcSet($asset = null, array $params = [], array $options = []): string
    {
        if (!$asset) {
            return '';
        }
        return OneImgix::$plugin->imgix->srcSet($asset, $params, $options);
    }

}
