<?php
/**
 * @copyright Copyright (c) One Design Company
 */

namespace onedesign\oneimgix\controllers;

use Craft;
use craft\helpers\UrlHelper;
use craft\web\Controller;
use onedesign\oneimgix\OneImgix;
use yii\web\Response;

class PurgeController extends Controller
{

    /**
     * Purges urls with Imgix
     *
     * @return Response|null
     * @throws \craft\errors\MissingComponentException
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionPurgeUrl()
    {
        $request = Craft::$app->getRequest();

        $this->requirePostRequest();
        $inputString = $request->getRequiredParam('urls');

        $urls = explode(PHP_EOL, $inputString);

        $uniqueUrls = [];
        foreach ($urls as $url) {
            $cleanUrl = UrlHelper::stripQueryString(trim($url));
            $uniqueUrls[$cleanUrl] = true;
        }

        $purger = OneImgix::getInstance()->purge;
        $results = [];

        foreach (array_keys($uniqueUrls) as $url) {
            $results[$url] = $purger->purgeUrl(trim($url));
        }

        $successful = array_keys($results, true);
        $failures = array_keys($results, false);

        $lineSeparator = PHP_EOL . "\t";

        if (count($successful) === count($urls) && count($failures) === 0) {
            Craft::info('Purge request successful for URLS' . $lineSeparator . implode($lineSeparator, $successful), 'one-imgix');
            Craft::$app->getSession()->setNotice(Craft::t('one-imgix', '{count} purge requests sent.', [
                'count' => count($successful)
            ]));
        }

        if (count($failures)) {
            Craft::error('Failed to purge URLs: ' . $lineSeparator . implode($lineSeparator, $failures), 'one-imgix');
            Craft::$app->getSession()->setError(Craft::t('one-imgix', '{count} URLs failed to purge', [
                'count' => count($failures)
            ]));
        }


        return $this->redirectToPostedUrl();
    }
}