<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\SteamApp]].
 *
 * @see \app\models\SteamApp
 */
class SteamAppQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\SteamApp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\SteamApp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    /**
     * @param $appId
     * @return $this
     */
    public function byAppId($appId)
    {
        return $this->andWhere(['app_id' => $appId]);
    }

}
