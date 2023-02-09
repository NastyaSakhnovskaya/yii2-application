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

class AccountController extends Controller {

    public function actionIndex()
    {
        $order=(new \yii\db\Query())
        ->from('order')
        ->join('JOIN', 'routes', 'routes.route_id=order.route_id')
        ->join('JOIN', 'bus', 'bus.bus_id=order.bus_id')
        ->join('JOIN', 'driver', 'driver.driver_id=order.driver_id')
        ->where(["user_id"=>Yii::$app->user->identity->username, "status" => 'active'])->all();

        return $this->render('/account/account', [
            'order' => $order,
        ]);
    }

    public function actionAccount()
    {
        
        if(Yii::$app->request->get()['status'] == 'active'){
            $order=(new \yii\db\Query())
            ->from('order')
            ->join('JOIN', 'routes', 'routes.route_id=order.route_id')
            ->join('JOIN', 'bus', 'bus.bus_id=order.bus_id')
            ->join('JOIN', 'driver', 'driver.driver_id=order.driver_id')
            ->where(["user_id"=>Yii::$app->user->identity->username, "status" => 'active'])->all();
        } else if(Yii::$app->request->get()['status'] == 'cancel') {
            $order=(new \yii\db\Query())
            ->from('order')
            ->join('JOIN', 'routes', 'routes.route_id=order.route_id')
            ->join('JOIN', 'bus', 'bus.bus_id=order.bus_id')
            ->join('JOIN', 'driver', 'driver.driver_id=order.driver_id')
            ->where(["user_id"=>Yii::$app->user->identity->username, "status" => 'cancel'])->all();
        } else {
            $order=(new \yii\db\Query())
            ->from('order')
            ->join('JOIN', 'routes', 'routes.route_id=order.route_id')
            ->join('JOIN', 'bus', 'bus.bus_id=order.bus_id')
            ->join('JOIN', 'driver', 'driver.driver_id=order.driver_id')
            ->where(["user_id"=>Yii::$app->user->identity->username])->all();
        }

        return $this->render('/account/account', [
            'order' => $order,
        ]);
    }

    public function actionCancel()
    {
        $order=Order::find()->where(["order_id"=> Yii::$app->request->get()['order_id']])->one();
        $order->status = 'cancel';
        $order->save();

        $route=Routes::find()->where(['route_id'=>$order->route_id])->one();
        $route->number_of_free_seats = $route->number_of_free_seats + $order->number_of_seats;
        $route->save();
        
        $order=(new \yii\db\Query())
        ->from('order')
        ->join('JOIN', 'routes', 'routes.route_id=order.route_id')
        ->join('JOIN', 'bus', 'bus.bus_id=order.bus_id')
        ->join('JOIN', 'driver', 'driver.driver_id=order.driver_id')
        ->where(["user_id"=>Yii::$app->user->identity->username, "status" => 'active'])->all();

        return $this->render('/account/account', [
            'order' => $order,
        ]);
    }

}