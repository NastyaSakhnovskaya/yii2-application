<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Routes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="routes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'direction_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direction_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'number_of_free_seats')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'driver_id')->textInput() ?>

    <?= $form->field($model, 'bus_id')->textInput() ?>

    <?= $form->field($model, 'route_status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
