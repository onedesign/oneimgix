<?php
/**
 * One Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with Imgix in Craft
 *
 * @link      https://onedesigncompany.com/
 * @copyright Copyright (c) 2020 One Design Company
 */

namespace onedesign\oneimgix\assetbundles;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    One Design Company
 * @package   OneImgix
 * @since     2.0.0
 */
class OneImgixAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@onedesign/oneimgix/assetbundles/oneimgix/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/OneImgix.js',
        ];

        $this->css = [
            'css/OneImgix.css',
        ];

        parent::init();
    }
}
