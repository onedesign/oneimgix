<?php
/**
 * @copyright Copyright (c) One Design Company
 */

namespace onedesign\oneimgix\controllers;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Json;
use craft\helpers\StringHelper;
use craft\web\Controller;
use craft\web\View;
use onedesign\oneimgix\OneImgix;
use putyourlightson\blitz\Blitz;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class PurgeController extends Controller
{

    public function actionPurgeUrl(): Response
    {
        $request = Craft::$app->getRequest();

        $this->requirePostRequest();
        $inputString = $request->getRequiredParam('urls');

        $urls = explode(PHP_EOL, $inputString);

        $purger = OneImgix::getInstance()->purge;
        $results = [];

        foreach ($urls as $url) {
            $url = trim($url);
            $results[$url] = $purger->purgeUrl(trim($url));
        }

        $successful = array_keys($results, true);
        $failures = array_keys($results, false);

        if (count($urls) === count($successful)) {
            Craft::$app->getSession()->setNotice('URL successfully purged.');
            Craft::info(sprintf('Succesfully purged %d urls: %s', count($successful), Json::encode($successful)), 'one-imgix');

            if ($request->getAcceptsJson()) {
                return $this->asJson([
                    'success' => true,
                    'message' => 'URL successfully purged.'
                ]);
            }
        } else {
            Craft::$app->getSession()->setError('Failed to purge URL.');
            Craft::error(sprintf('Failed to purge %d urls: %s', count($failures), Json::encode($failures)), 'one-imgix');



            if ($request->getAcceptsJson()) {
                return $this->asJson([
                    'success' => false,
                    'message' => 'Failed to purge URL.'
                ]);
            }
        }

        return $this->redirectToPostedUrl();
    }

}