<?php
/**
 * One Imgix plugin for Craft CMS 3.x
 *
 * Tools for working with Imgix in Craft
 *
 * @link      https://onedesigncompany.com/
 * @copyright Copyright (c) 2020 One Design Company
 */

namespace onedesign\oneimgix;

use craft\events\GetAssetThumbUrlEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Assets;
use craft\services\Utilities;
use onedesign\oneimgix\services\ImgixService;
use onedesign\oneimgix\services\PurgeService;
use onedesign\oneimgix\utilities\PurgeUtility;
use onedesign\oneimgix\variables\OneImgixVariable;
use onedesign\oneimgix\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class OneImgix
 *
 * @author    One Design Company
 * @package   OneImgix
 * @since     2.0.0
 *
 * @property ImgixService $imgix
 * @property PurgeService $purge
 */
class OneImgix extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var OneImgix
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '2.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'imgix' => ImgixService::class,
            'purge' => PurgeService::class
        ]);

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('oneImgix', OneImgixVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function(PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Event::on(Utilities::class, Utilities::EVENT_REGISTER_UTILITY_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = PurgeUtility::class;
            }
        );

        // TODO: Make this configurable
        Event::on(Assets::class, Assets::EVENT_GET_ASSET_THUMB_URL,
            static function(GetAssetThumbUrlEvent $event) {
                if ($event->asset !== null && $event->asset->kind === 'image') {
                    $transformedImage = self::getInstance()->imgix->url($event->asset, [
                        'w' => $event->width,
                        'h' => $event->height,
                        'crop' => 'fit'
                    ]);

                    if ($transformedImage !== null) {
                        $event->url = $transformedImage;
                    }
                }
            }
        );

        Craft::info(
            Craft::t(
                'one-imgix',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'one-imgix/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
