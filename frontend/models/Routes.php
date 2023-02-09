<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "routes".
 *
 * @property int $route_id
 * @property string|null $direction_from
 * @property string|null $direction_to
 * @property string|null $date
 * @property string|null $time
 * @property int|null $number_of_free_seats
 * @property int|null $price
 * @property int|null $driver_id
 * @property int|null $bus_id
 * @property string $route_status
 */
class Routes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'routes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'time'], 'safe'],
            [['number_of_free_seats', 'price', 'driver_id', 'bus_id'], 'integer'],
            [['route_status'], 'required'],
            [['direction_from', 'direction_to', 'route_status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'route_id' => 'Route ID',
            'direction_from' => 'Direction From',
            'direction_to' => 'Direction To',
            'date' => 'Date',
            'time' => 'Time',
            'number_of_free_seats' => 'Number Of Free Seats',
            'price' => 'Price',
            'driver_id' => 'Driver ID',
            'bus_id' => 'Bus ID',
            'route_status' => 'Route Status',
        ];
    }
}
