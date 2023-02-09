<?php
namespace frontend\controllers;

use yii\helpers\Html;
use yii\web\Controller;
use yii\data\Pagination;
use Yii;
use frontend\models\OrderForm;
use frontend\models\Routes;
use frontend\models\Order;
use frontend\models\Bus;
use frontend\models\Driver;

class DriverController extends Controller {

    public function actionIndex()
    {
        $people=Order::find()->andWhere(['route_id'=>Yii::$app->request->get()['route_id']])->andWhere(['!=', 'status', 'cancel'])->all();

        return $this->render('/drivers/driver', [
            'people' => $people,
        ]);
    }

    public function actionCheck()
    {
        $people=Order::find()->where(['order_id'=>Yii::$app->request->get()['order_id']])->one();
        $people->status = Yii::$app->request->get()['type'];
        $people->save();

        $peopleNew = Order::find()->andWhere(['!=', 'status', 'cancel'])->andWhere(['route_id'=> $people->route_id])->all();

        return $this->render('/drivers/driver', [
            'people' => $peopleNew,
        ]);
    }
 
    public function actionChange()
    {
        $change=Routes::find()->where(['route_id'=>Yii::$app->request->get()['route_id']])->one();
        $change->route_status = 'complete';
        $change->save();

        return $this->goHome();
    }
}