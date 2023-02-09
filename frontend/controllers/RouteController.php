<?php
namespace frontend\controllers;

use yii\helpers\Html;
use yii\web\Controller;
use yii\data\Pagination;
use Yii;
use frontend\models\OrderForm;
use frontend\models\Routes;
use frontend\models\Order;


class RouteController extends Controller { 

    public function actionIndex()
    {
        return $this->render('route');
    }

    public function actionOrder()
    {
        $model=new OrderForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            

            $route = Routes::find()->where(['route_id'=> Yii::$app->request->get()['order_id']])->one();
            if($route->number_of_free_seats >= $model->number_of_seats) {
                $route->number_of_free_seats = $route->number_of_free_seats - Html::encode($model->number_of_seats);
                $route->save();

                $order = new Order();
                $order_find = Routes::find()->where(['route_id' =>  Yii::$app->request->get()['order_id']])->one();
                $order->route_id =  Yii::$app->request->get()['order_id'];
                $order->user_id = Yii::$app->user->identity->username;
                $order->surname =  Html::encode($model->surname);
                $order->name =  Html::encode($model->name);
                $order->phone =  Html::encode($model->phone);
                $order->number_of_seats =  Html::encode($model->number_of_seats);
                $order->status =  'active';
                $order->bus_id =  $order_find->bus_id;
                $order->driver_id =  $order_find->driver_id;
                $order->save();

                return $this->goHome();
            } else{
                $routes=Routes::find()->where(['route_id'=> Yii::$app->request->get()['order_id']])->one();
                return $this->render('/order/order', [
                    'route' => $routes,
                    'model' => $model,
                    'error_string' => 'В наличие нет столько свободных мест.'
                ]);
            }
            
        } 
        else {
            $routes=Routes::find()->where(['route_id'=> Yii::$app->request->get()['order_id']])->one();
            return $this->render('/order/order', [
                'route' => $routes,
                'model' => $model,
            ]);
        }
    }
}