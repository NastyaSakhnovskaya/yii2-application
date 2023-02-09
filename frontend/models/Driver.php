<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "driver".
 *
 * @property int $driver_id
 * @property string|null $driver_name
 * @property string|null $driver_surname
 * @property string|null $phone
 * @property string $driver_login
 */
class Driver extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'driver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver_login'], 'required'],
            [['driver_name', 'driver_surname', 'phone', 'driver_login'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'driver_id' => 'Driver ID',
            'driver_name' => 'Driver Name',
            'driver_surname' => 'Driver Surname',
            'phone' => 'Phone',
            'driver_login' => 'Driver Login',
        ];
    }
}
