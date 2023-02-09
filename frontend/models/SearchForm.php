<?php

namespace frontend\models;

use yii;
use yii\base\Model;

class SearchForm extends Model
{
    public $from;
    public $to;
    public $date;
    public $person;
    public function rules(){
    return[[['from','to', 'date', 'person'],'required']];
    }
}