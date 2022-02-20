<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DailyPlaytime;
use yii\db\Expression;
use yii\db\Query;

/**
 * DailyPlaytimeSearch represents the model behind the search form of `app\models\DailyPlaytime`.
 */
class DailyPlaytimeSearch extends DailyPlaytime
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_id', 'minutes', 'playtime_2weeks', 'playtime_forever'], 'integer'],
            [['date', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DailyPlaytime::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'app_id' => $this->app_id,
            'date' => $this->date,
            'minutes' => $this->minutes,
            'playtime_2weeks' => $this->playtime_2weeks,
            'playtime_forever' => $this->playtime_forever,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }


    public function searchDailySummary($params)
    {
        $query = new Query();
        $query->from(self::tableName());

        $summ = new Expression('sum(minutes)');

        $query->select(['date', 'app_id', 'duration' => $summ]);
        $query->groupBy(['date', 'app_id']);
        $query->orderBy(['date' => SORT_DESC, 'duration' => SORT_DESC]);

        $data = $query->all();

        return $data;
    }

    public function searchMonthlySummary($params)
    {
        $query = new Query();
        $query->from(self::tableName());

        $summ = new Expression('sum(minutes)');
        $month = new Expression('MONTH(date)');

        $query->select(['month' => $month, 'app_id', 'duration' => $summ]);
        $query->groupBy([$month, 'app_id']);
        $query->orderBy(['month' => SORT_DESC, 'duration' => SORT_DESC]);

        $data = $query->all();

        return $data;
    }

    public function searchYearSummary($params)
    {
        $query = new Query();
        $query->from(self::tableName());

        $summ = new Expression('sum(minutes)');
        $year = new Expression('YEAR(date)');

        $query->select(['year' => $year, 'app_id', 'duration' => $summ]);
        $query->groupBy([$year, 'app_id']);
        $query->orderBy(['year' => SORT_DESC, 'duration' => SORT_DESC]);

        $data = $query->all();

        return $data;
    }
}
