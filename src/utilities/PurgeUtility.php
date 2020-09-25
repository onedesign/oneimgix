<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace onedesign\oneimgix\utilities;

use Craft;
use craft\base\Utility;

class PurgeUtility extends Utility
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('one-imgix', 'Imgix Purge');
    }

    /**
     * @inheritdoc
     */
    public static function id(): string
    {
        return 'one-imgix-purge';
    }

    /**
     * @inheritdoc
     */
    public static function contentHtml(): string
    {
        return Craft::$app->getView()->renderTemplate('one-imgix/_utility', [
            'actions' => self::getActions(),
        ]);
    }

    /**
     * Returns available actions.
     *
     * @param bool $showAll
     *
     * @return array
     */
    public static function getActions(bool $showAll = false): array
    {
        $actions = [];

        $actions[] = [
            'id' => 'purge-url',
            'label' => 'Purge',
            'fields' => [
                'urls' => [
                    'label' => Craft::t('one-imgix', Craft::t('one-imgix', 'URL(s)')),
                    'instructions' => Craft::t('one-imgix', 'Purge the Imgix cache of a one or multiple urls. Multiple URLs should be separated by a line break.'),
                ]
            ]
        ];

        return $actions;
    }
}

