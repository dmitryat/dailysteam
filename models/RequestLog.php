<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%request_log}}".
 *
 * @property int $id
 * @property string|null $request
 * @property string|null $response
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $error_message
 */
class RequestLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request', 'error_message'], 'string'],
            [['response', 'created_at'], 'safe'],
            [['status'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'request' => Yii::t('app', 'Request'),
            'response' => Yii::t('app', 'Response'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'error_message' => Yii::t('app', 'Error Message'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\RequestLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\RequestLogQuery(get_called_class());
    }
}
