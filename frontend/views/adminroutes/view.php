<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Routes */

$this->title = $model->route_id;
$this->params['breadcrumbs'][] = ['label' => 'Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="routes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'route_id' => $model->route_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'route_id' => $model->route_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'route_id',
            'direction_from',
            'direction_to',
            'date',
            'time',
            'number_of_free_seats',
            'price',
            'driver_id',
            'bus_id',
            'route_status',
        ],
    ]) ?>

</div>
