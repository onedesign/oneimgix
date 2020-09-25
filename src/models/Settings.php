<?php
/**
 * One Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with Imgix in Craft
 *
 * @link      https://onedesigncompany.com/
 * @copyright Copyright (c) 2020 One Design Company
 */

namespace onedesign\oneimgix\models;

use onedesign\oneimgix\OneImgix;

use Craft;
use craft\base\Model;

/**
 * @author    One Design Company
 * @package   OneImgix
 * @since     2.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $apiKey = '';

    /**
     * @var string
     */
    public $sourceName = '';

    /**
     * @var string
     */
    public $secureUrlToken = '';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apiKey', 'sourceName'], 'required'],
            ['apiKey', 'string'],
            ['sourceName', 'string'],
            ['secureUrlToken', 'string']
        ];
    }
}
