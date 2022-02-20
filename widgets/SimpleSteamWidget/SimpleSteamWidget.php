<?php

/**
 * Created by PhpStorm.
 * User: dmitryat
 * Date: 13/08/20
 * Time: 13:59
 */

namespace app\widgets\SimpleSteamWidget;

use yii\base\Widget;

class SimpleSteamWidget extends Widget
{

    public $data;

    public function run()
    {
        return $this->render('main', [
            'data' => $this->data,
        ]);
    }

}