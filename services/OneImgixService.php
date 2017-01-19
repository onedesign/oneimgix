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

    public function getImgixSourceUrl()
    {
        $source = $this->getImgixSource();
        return "https://${source}.imgix.net/";
    }

    public function getApiKey()
    {
        return $this->settings->apiKey;
    }

    public function getAssetBaseUrl()
    {
        return $this->settings->assetBaseUrl;
    }

    public function url($asset, $params = [])
    {
      $imgixBaseUrl = $this->getImgixSourceUrl();
      $assetBaseUrl = $this->getAssetBaseUrl();
      $filepath = str_replace($assetBaseUrl, '', $asset->url);
      $url = $imgixBaseUrl . $filepath;
      foreach ($params as $key => $val) {
        if ($val) {
          $url = $url . '&' . "${key}=${val}";
        }
      }
      return $url;
    }

    public function purgeAsset($asset)
    {
      $baseOriginalUrl = $this->getAssetBaseUrl();
      $baseImgixUrl = $this->getImgixSourceUrl();
      $url = str_replace($baseOriginalUrl, $baseImgixUrl, $asset->url);
      $result = $this->purgeImgixUrl($url);
    }

    public function purgeImgixUrl($imageUrl)
    {
        $apiKey = $this->getApiKey();
        $purgeUrl = 'https://api.imgix.com/v2/image/purger';
        $client = new \Guzzle\Http\Client();

        try {
            $request = $client->post($purgeUrl,
                [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($apiKey . ':')
                ],
                [
                    'url' => $imageUrl
                ]
            );

            $response = $request->send();
        } catch (\Guzzle\Http\Exception\ClientErrorResponseException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            OneImgixPlugin::log('Imgix purge request returned a non-successful response: ' . $statusCode, LogLevel::Error, true);
            return false;
        }

        OneImgixPlugin::log('Purged Imgix image at: ' . $imageUrl, LogLevel::Info, true);
        return $response;
    }

}