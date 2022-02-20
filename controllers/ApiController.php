<?php
/**
 * Created by PhpStorm.
 * User: dmitryat
 * Date: 13/08/20
 * Time: 12:32
 */

namespace app\controllers;


use app\components\SteamApi;
use app\components\SteamDataParser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ApiController extends Controller
{

    public $key = 'xplane';

    /**
     * @param $key
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($key = null)
    {
        if ($key != $this->key) {
            throw new NotFoundHttpException();
        }

        $steam = new SteamApi();

        $data = $steam->getRecentlyPlayedGamesData();

        $parser = new SteamDataParser();

        $parser->addPlayedGames($data);

        return "Ok";
    }

}