<?php

/**
 * Created by PhpStorm.
 * User: dmitryat
 * Date: 12/08/20
 * Time: 18:06
 */

namespace app\components;

use app\models\RequestLog;
use yii\base\Component;

/**
 * Class SteamApi
 * @package app\components
 */
class SteamApi extends Component
{
    public $steamApiKey    = '';
    public $defaultSteamId = '';

    public function getDefaultSteamId()
    {
        return $this->defaultSteamId;
    }

    public function getRecentlyPlayedGamesData($steamId = null)
    {
        $steamId  = $steamId ?: $this->getDefaultSteamId();
        $data = $this->requestRecentlyPlayedGames($steamId);

        return $data;
    }

    public function logRequest($source, $response)
    {
        $request           = new RequestLog();
        $request->request  = $source;
        $request->response = $response;

        return $request->save();
    }

    protected function requestRecentlyPlayedGames($steamId = null)
    {
        $source = $this->getSourceUrl($steamId);

        $response = file_get_contents($source);
        $data = json_decode($response, true);

        $this->logRequest($source, $data);

        return $data;
    }

    /**
     * @param $sourceUrl
     * @param $destPath
     * @return bool
     * @throws \Exception
     */
    public function downloadCsvFile($sourceUrl, $destPath)
    {
        $content = file_get_contents($sourceUrl);

        $destPath = str_replace('//', '/', $destPath);
        $fd       = fopen($destPath, 'w');

        if (!$fd) {
            throw new \Exception("Cannot create file {$destPath}");
        }

        fwrite($fd, $content);

        fclose($fd);

        return true;
    }


    /**
     * generate data feeds request url
     *
     * @param $steamId
     * @return string
     * @internal param $type
     * @internal param $options
     */
    public function getSourceUrl($steamId)
    {
//        $options = http_build_query($options);

        $sourceUrl = "https://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key={$this->steamApiKey}&steamid={$steamId}&format=json";

        return $sourceUrl;
    }

}