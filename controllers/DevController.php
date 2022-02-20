<?php
/**
 * Created by PhpStorm.
 * User: dmitryat
 * Date: 12/08/20
 * Time: 18:55
 */

namespace app\controllers;


use app\components\SteamApi;
use app\components\SteamDataParser;
use app\models\RequestLog;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DevController extends Controller
{

    public function actionIndex()
    {
        return "test";
    }


    public function actionUpdate()
    {

        $domain = Yii::$app->request->getHostName();

        if (strpos($domain, 'dailysteam.local') === false) {
            throw new NotFoundHttpException();
        }

        $steam = new SteamApi();
        $data = $steam->getRecentlyPlayedGamesData();

        $parser = new SteamDataParser();

        $parser->addPlayedGames($data);

        var_dump($data);
    }


    public function actionParseRequest($id = null)
    {
//        $id = Yii::$app->request->get('id');  need if parent by yii/base/controller
        $log = $id ? RequestLog::findOne($id) : RequestLog::find()->orderBy(['id' => SORT_DESC])->one();

        if (!$log) {
            return "log not found";
        }

        $data = $log->response;

        $parser = new SteamDataParser();

        $parser->addPlayedGames($data);

        return "done";
    }

    public function actionDateTest()
    {
        $date = date('Y-m-d');

        $tz = new \DateTimeZone('UTC');
        $tzLocal = new \DateTimeZone('Asia/Yekaterinburg');
//        $tz = new \DateTimeZone();
        $d2 = new DateTime('+2 hours');
        $d2a = new DateTime('+2 hours', $tzLocal);
        $d3 = new DateTime('now', $tz);


        $playtimeDateTime = new DateTime('-5 hours', $tzLocal);

        var_dump($playtimeDateTime);

        $date = $playtimeDateTime->format('Y-m-d');

        echo $date;
    }


    public function actionDate()
    {
        $tzLocal = new \DateTimeZone('Asia/Yekaterinburg');
        $playtimeDateTime = new DateTime('-6 hours', $tzLocal);

        $str = "Yekat -6 hrs time : ". $playtimeDateTime->format('Y-m-d H:i:s');
        $str .= "<br>";


        $parser = new SteamDataParser();
        $str .= "parser date : ".$parser->getCurrentPlaytimeDate();

        return $str;
    }


}