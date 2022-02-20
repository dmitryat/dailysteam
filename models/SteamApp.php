<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%steam_app}}".
 *
 * @property int $id
 * @property int|null $app_id
 * @property string|null $name
 * @property int|null $initial_playtime
 * @property string|null $created_at
 */
class SteamApp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%steam_app}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'initial_playtime'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'initial_playtime' => Yii::t('app', 'Initial Playtime'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\SteamAppQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\SteamAppQuery(get_called_class());
    }
}
