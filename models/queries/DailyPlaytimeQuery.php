<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\DailyPlaytime]].
 *
 * @see \app\models\DailyPlaytime
 */
class DailyPlaytimeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\DailyPlaytime[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\DailyPlaytime|array|null
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

    /**
     * @param $date
     * @return $this
     */
    public function byDate($date)
    {
        return $this->andWhere(['date' => $date]);
    }

    /**
     * @param $date
     * @return $this
     */
    public function excludeDate($date)
    {
        return $this->andWhere(['not', ['date' => $date]]);
    }
}
