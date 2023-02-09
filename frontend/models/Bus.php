<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "bus".
 *
 * @property int $bus_id
 * @property string|null $bus_number
 * @property string|null $brand
 * @property string|null $color
 * @property int|null $number_of_seats
 */
class Bus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_of_seats'], 'integer'],
            [['bus_number', 'brand', 'color'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bus_id' => 'Bus ID',
            'bus_number' => 'Bus Number',
            'brand' => 'Brand',
            'color' => 'Color',
            'number_of_seats' => 'Number Of Seats',
        ];
    }
}
