<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Bus;

/**
 * BusSearch represents the model behind the search form of `frontend\models\Bus`.
 */
class BusSearch extends Bus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bus_id', 'number_of_seats'], 'integer'],
            [['bus_number', 'brand', 'color'], 'safe'],
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
        $query = Bus::find();

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
            'bus_id' => $this->bus_id,
            'number_of_seats' => $this->number_of_seats,
        ]);

        $query->andFilterWhere(['like', 'bus_number', $this->bus_number])
            ->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'color', $this->color]);

        return $dataProvider;
    }
}
