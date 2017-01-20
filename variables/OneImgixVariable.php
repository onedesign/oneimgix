<?php
/**
 * OneImgix plugin for Craft CMS
 *
 * OneImgix Variable
 *
 * @author    One Design Company
 * @copyright Copyright (c) 2017 One Design Company
 * @link      https://www.onedesigncompany.com
 * @package   OneImgix
 * @since     1.0.0
 */

namespace Craft;

class OneImgixVariable
{
    public function getImgixSource()
    {
        return craft()->oneImgix->getImgixSource();
    }
    
    public function getImgixSourceUrl()
    {
        return craft()->oneImgix->getImgixSourceUrl();
    }
    
    public function getAssetBaseUrl()
    {
        return craft()->oneImgix->getAssetBaseUrl();
    }

    public function url($asset, $params = [], $startQueryString = true)
    {
        return craft()->oneImgix->url($asset, $params, $startQueryString);
    }
}