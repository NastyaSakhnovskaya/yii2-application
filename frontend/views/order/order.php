<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\MaskedInput;

?>

<div class="order_content">
    <h2>Заказать</h2>
    <div class="order_info">
    <?php 
        $time = new DateTime($route->time);
    ?>
        <p><b>Направление:</b><?=$route->direction_from?>-<?=$route->direction_to?></p>
        <p><b>Дата и время отправления: </b><?=$route->date?>, <?=date_format($time, 'H:i')?></p>
        <p><b>Цена:</b><?=$route->price?> BYN</p>
    </div>

    <span style="color:red"><?=$error_string?></span><br> 

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'surname')->label('Фамилия')->textInput(['placeholder' => 'Иванов']); ?>
        <?= $form->field($model, 'name')->label('Имя')->textInput(['placeholder' => 'Иван']);  ?>
        <?= $form->field($model, 'phone')->label('Номер телефона')->widget(MaskedInput::className(),['mask'=>'+375 (99) 999-99-99'])->textInput(['placeholder' => '+375 (29) 999-99-99']) ?>
        
        <?= $form->field($model, 'number_of_seats')->label('Количество мест') ->dropDownList(['1'=>'1', '2'=>'2','3'=>'3','4'=>'4'],['prompt' => 'Выберите один вариант']);  ?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div>