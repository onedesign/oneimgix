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
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (OneImgix::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
