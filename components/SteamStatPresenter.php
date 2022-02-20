<?php
/**
 * Created by PhpStorm.
 * User: dmitryat
 * Date: 13/08/20
 * Time: 12:48
 */

namespace app\components;


use app\models\DailyPlaytimeSearch;
use app\models\SteamApp;
use DateTime;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class SteamStatPresenter extends Component
{

    public $apps;

    /**
     *
     */
    public function getDaily()
    {
        $searchModel = new DailyPlaytimeSearch();
        $daily       = $searchModel->searchDailySummary(null);

        return $this->prepareData($daily);
    }


    /**
     *
     */
    public function getMonthly()
    {
        $searchModel = new DailyPlaytimeSearch();
        $daily       = $searchModel->searchMonthlySummary(null);

        return $this->prepareData($daily);
    }

    /**
     *
     */
    public function getYear()
    {
        $searchModel = new DailyPlaytimeSearch();
        $daily       = $searchModel->searchYearSummary(null);

        return $this->prepareData($daily);
    }

    /**
     * @return array
     */
    protected function getApps()
    {
        if (empty($this->apps)) {
            $this->apps = ArrayHelper::map(SteamApp::find()->all(), 'app_id', 'name');
        }

        return $this->apps;
    }

    protected function getAppName($appId)
    {
        return ArrayHelper::getValue($this->getApps(), $appId);
    }

    /**
     * @param $data
     * @return array
     */
    protected function prepareData($data)
    {
        $playtime = [];

        foreach ($data as $item) {

            $title    = $this->getPeriodTitle($item);
            $appId    = ArrayHelper::getValue($item, 'app_id');
            $duration = ArrayHelper::getValue($item, 'duration');

            $apps = ArrayHelper::getValue($playtime, $title, []);

            $apps[] = [
                'app_id'   => $appId,
                'game'     => $this->getAppName($appId),
                'duration' => $duration,
            ];

            $playtime[$title] = $apps;
        }

        return $playtime;
    }

    /**
     * @param $item
     * @param $defaultValue
     * @return mixed|string
     */
    protected function getPeriodTitle($item, $defaultValue = null)
    {
        $period = ArrayHelper::getValue($item, 'period_title');

        if ($period) {
            return $period;
        }

        $date = ArrayHelper::getValue($item, 'date');

        if ($date) {
            return $date;
        }

        $month = ArrayHelper::getValue($item, 'month');

        if ($month) {
            $month = is_numeric($month) ? DateTime::createFromFormat('!m', $month)->format('F') : $month;
            return $month;
        }

        $year = ArrayHelper::getValue($item, 'year');

        if ($year) {
            return $year;
        }

        return $defaultValue;
    }

}