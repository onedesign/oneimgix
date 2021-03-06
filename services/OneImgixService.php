<?php
/**
 * OneImgix plugin for Craft CMS
 *
 * OneImgix Service
 *
 * @author    One Design Company
 * @copyright Copyright (c) 2017 One Design Company
 * @link      https://www.onedesigncompany.com
 * @package   OneImgix
 * @since     1.0.0
 */

namespace Craft;

use Imgix\UrlBuilder;

class OneImgixService extends BaseApplicationComponent
{
    protected $settings;

    public function __construct()
    {
        $this->settings = craft()->plugins->getPlugin('oneImgix')->getSettings();
    }

    public function getImgixSource()
    {
        return $this->settings->sourceName;
    }

    public function getImgixDomain()
    {
        $source = $this->getImgixSource();
        return "${source}.imgix.net";
    }

    public function getApiKey()
    {
        return $this->settings->apiKey;
    }

    public function getAssetBaseUrl()
    {
        return $this->settings->assetBaseUrl;
    }

    public function getSecureUrlToken()
    {
        return $this->settings->secureUrlToken;
    }

    public function builtImgixUrl($asset, $params = [])
    {
        $imgixUrl = $this->getImgixDomain();
        $assetBaseUrl = $this->getAssetBaseUrl();
        $builder = new UrlBuilder($imgixUrl);
        $builder->setUseHttps(true);
        $filepath = str_replace($assetBaseUrl, '', $asset->url);
        $secureUrlToken = $this->getSecureUrlToken();
        if (strlen($secureUrlToken)) {
          $builder->setSignKey($secureUrlToken);
        }
        return $builder->createURL($filepath, $params);
    }

    public function url($asset, $params = [])
    {
      return $this->builtImgixUrl($asset, $params);
    }

    public function purgeAsset($asset)
    {
      $baseOriginalUrl = $this->getAssetBaseUrl();
      $imgixDomain = $this->getImgixDomain();
      $baseImgixUrl = 'https://' . $imgixDomain . '/';
      $url = str_replace($baseOriginalUrl, $baseImgixUrl, $asset->url);
      $result = $this->purgeImgixUrl($url);
    }

    public function purgeImgixUrl($imageUrl)
    {
        $apiKey = $this->getApiKey();
        $purgeUrl = 'https://api.imgix.com/api/v1/purge';

        try {
            $params = [
                'data' => [
                    'attributes' => [
                        'url' => $imageUrl,
                    ],
                    'type' => 'purges'
                ]
            ];

            $encodedParams = json_encode($params);

            $client = new \Guzzle\Http\Client();
            $request = $client->post($purgeUrl,
                [
                    'Content-Type' => 'application/vnd.api+json',
                    'Authorization' => 'Bearer ' . $apiKey
                ],
                $encodedParams
            );

            $response = $request->send();
        } catch (\Guzzle\Http\Exception\ClientErrorResponseException $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $responseBody = $exception->getResponse()->getBody(true);
            OneImgixPlugin::log(sprintf('Imgix purge request returned a non-successful response: [%s] %s', $statusCode, $responseBody), LogLevel::Error, true);
            return false;
        }

        OneImgixPlugin::log('Purged Imgix image at: ' . $imageUrl, LogLevel::Info, true);
        return $response;
    }

}
