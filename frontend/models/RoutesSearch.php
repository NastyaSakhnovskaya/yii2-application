<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Routes;

/**
 * RoutesSearch represents the model behind the search form of `frontend\models\Routes`.
 */
class RoutesSearch extends Routes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route_id', 'number_of_free_seats', 'price', 'driver_id', 'bus_id'], 'integer'],
            [['direction_from', 'direction_to', 'date', 'time', 'route_status'], 'safe'],
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
        $query = Routes::find();

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
            'route_id' => $this->route_id,
            'date' => $this->date,
            'time' => $this->time,
            'number_of_free_seats' => $this->number_of_free_seats,
            'price' => $this->price,
            'driver_id' => $this->driver_id,
            'bus_id' => $this->bus_id,
        ]);

        $query->andFilterWhere(['like', 'direction_from', $this->direction_from])
            ->andFilterWhere(['like', 'direction_to', $this->direction_to])
            ->andFilterWhere(['like', 'route_status', $this->route_status]);

        return $dataProvider;
    }
}
