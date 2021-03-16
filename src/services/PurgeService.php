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
class PurgeService extends Component
{
    protected $client = null;

    protected function getClient()
    {
        if (!$this->client) {
            $api_key = Craft::parseEnv(OneImgix::getInstance()->getSettings()->apiKey);
            $this->client = Craft::createGuzzleClient([
                'base_uri' => 'https://api.imgix.com',
                'headers' => [
                    'Content-Type' => 'application/vnd.api+json',
                    'Authorization' => 'Bearer ' . $api_key
                ]
            ]);
        }

        return $this->client;
    }

    public function purgeUrl(string $url)
    {
        $client = $this->getClient();

        try {
            $response = $client->post('api/v1/purge', [
                'json' => [
                  'data' => [
                    'attributes' => [
                        'url' => $url,
                    ],
                    'type' => 'purges'
                  ]
                ]
            ]);
            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            Craft::error($e->getMessage(), 'one-imgix');
            return false;
        }
    }

}
