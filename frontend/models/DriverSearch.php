<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Driver;

/**
 * DriverSearch represents the model behind the search form of `frontend\models\Driver`.
 */
class DriverSearch extends Driver
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver_id'], 'integer'],
            [['driver_name', 'driver_surname', 'phone', 'driver_login'], 'safe'],
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
        $query = Driver::find();

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
            'driver_id' => $this->driver_id,
        ]);

        $query->andFilterWhere(['like', 'driver_name', $this->driver_name])
            ->andFilterWhere(['like', 'driver_surname', $this->driver_surname])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'driver_login', $this->driver_login]);

        return $dataProvider;
    }
}
