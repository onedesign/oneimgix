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
    // Public Methods
    // =========================================================================

    final public function url(Asset $asset, array $params = []): string
    {
        return OneImgix::$plugin->oneImgixService->url($asset, $params);
    }

    public function srcSet(Asset $asset, array $params = [], array $options = []): string
    {
        return OneImgix::$plugin->oneImgixService->srcSet($asset, $params, $options);
    }

}
