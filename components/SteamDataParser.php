<?php
/**
 * Created by PhpStorm.
 * User: dmitryat
 * Date: 12/08/20
 * Time: 19:21
 */

namespace app\components;


use app\models\DailyPlaytime;
use app\models\SteamApp;
use DateTime;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class SteamDataParser extends Component
{

    /**
     * @param $data
     */
    public function processSteamData($data)
    {
        $this->addPlayedGames($data);
    }

    /**
     * @param $data
     * @return bool
     */
    public function addPlayedGames($data)
    {
        $response = ArrayHelper::getValue($data, 'response');

        $count = ArrayHelper::getValue($response, 'total_count');
        $games = ArrayHelper::getValue($response, 'games', []);

        foreach ($games as $game) {
            $appId          = ArrayHelper::getValue($game, 'appid');
            $appName        = ArrayHelper::getValue($game, 'name');
            $playtime2weeks = ArrayHelper::getValue($game, 'playtime_2weeks');
            $playtimeTotal  = ArrayHelper::getValue($game, 'playtime_forever');


            $this->appendMissedSteamApp($appId, $appName, $playtimeTotal);

            $date = $this->getCurrentPlaytimeDate();

            $lastTotal = $this->getLastPlaytime($date, $appId);

            $playtime = (integer)$lastTotal ? $playtimeTotal - $lastTotal : $playtime2weeks; // add 2weeks playtime for one day if first record

            if ($playtime) {
                $this->updateDailyPlaytime($date, $appId, $playtime, $playtimeTotal, $playtime2weeks);
            }


        }

        return true;
    }

    /**
     * @return string
     */
    public function getCurrentPlaytimeDate()
    {
        $tzLocal = new \DateTimeZone('Asia/Yekaterinburg');

        $playtimeDateTime = new DateTime('-6 hours', $tzLocal);

        $date = $playtimeDateTime->format('Y-m-d');

        return $date;
    }


    /**
     * @param $appId
     * @param $appName
     * @param $totalMinutes
     * @return bool
     */
    protected function appendMissedSteamApp($appId, $appName, $totalMinutes)
    {
        if (SteamApp::find()->byAppId($appId)->exists()) {
            return true;
        }

        $app = new SteamApp();

        $app->app_id           = $appId;
        $app->name             = $appName;
        $app->initial_playtime = $totalMinutes;

        return $app->save();
    }

    /**
     * @param $date
     * @param $appId
     * @return int|null
     */
    protected function getLastPlaytime($date, $appId)
    {
        $lastPlayDate = DailyPlaytime::find()->byAppId($appId)->excludeDate($date)->orderBy(['date' => SORT_DESC])->one();

        return $lastPlayDate ? $lastPlayDate->playtime_forever : null;
    }

    /**
     * @param      $date
     * @param      $appId
     * @param      $playtimeDaily
     * @param      $playtimeTotal
     * @param null $playtime2weeks
     * @return DailyPlaytime|array|null
     */
    protected function updateDailyPlaytime($date, $appId, $playtimeDaily, $playtimeTotal, $playtime2weeks = null)
    {
        $daily = DailyPlaytime::find()->byAppId($appId)->byDate($date)->one();

        if (!$daily) {            
            $daily = new DailyPlaytime();
            $daily->app_id = $appId;
            $daily->date = $date;
        }

        $daily->minutes = $playtimeDaily;
        $daily->playtime_forever = $playtimeTotal;
        $daily->playtime_2weeks = $playtime2weeks;

        $daily->save();
        
        return $daily;
    }

}