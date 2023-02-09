<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Driver */

$this->title = $model->driver_id;
$this->params['breadcrumbs'][] = ['label' => 'Drivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="driver-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'driver_id' => $model->driver_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'driver_id' => $model->driver_id], [
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
            'driver_id',
            'driver_name',
            'driver_surname',
            'phone',
            'driver_login',
        ],
    ]) ?>

</div>
