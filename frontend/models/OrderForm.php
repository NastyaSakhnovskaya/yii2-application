<?php

namespace frontend\models;

use yii;
use yii\base\Model;

class OrderForm extends Model
{
    public $surname;
    public $name;
    public $phone;
    public $number_of_seats;
    public function rules(){
    return[[['surname','name', 'phone', 'number_of_seats'],'required'],  
            ['phone', 'match', 'pattern' => '/\+375\s\([0-9]{2}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', 'message' => ' Что-то не так' ]];
    }
} 