<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%daily_playtime}}".
 *
 * @property int $id
 * @property int|null $app_id
 * @property string|null $date
 * @property int|null $minutes
 * @property int|null $playtime_2weeks
 * @property int|null $playtime_forever
 * @property string|null $created_at
 */
class DailyPlaytime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%daily_playtime}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'minutes', 'playtime_2weeks', 'playtime_forever'], 'integer'],
            [['date', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'app_id' => Yii::t('app', 'App ID'),
            'date' => Yii::t('app', 'Date'),
            'minutes' => Yii::t('app', 'Minutes'),
            'playtime_2weeks' => Yii::t('app', 'Playtime 2weeks'),
            'playtime_forever' => Yii::t('app', 'Playtime Forever'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\DailyPlaytimeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\DailyPlaytimeQuery(get_called_class());
    }
}
