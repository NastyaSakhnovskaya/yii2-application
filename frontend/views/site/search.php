<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    use yii\jui\DatePicker;
?>
<br><br><br>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'from')->label('Откуда')->dropDownList(['Минск'=>'Минск','Бобруйск'=>'Бобруйск','Кировск'=>'Кировск','Могилев'=>'Могилев'],['prompt' => 'Выберите один вариант']); ?>
    <?= $form->field($model, 'to')->label('Куда')->dropDownList(['Минск'=>'Минск','Бобруйск'=>'Бобруйск','Кировск'=>'Кировск','Могилев'=>'Могилев'],['prompt' => 'Выберите один вариант']);  ?>
    <?= $form->field($model, 'date')->label('Дата отправления')->textInput(['placeholder' => '2022-04-23']) ?>
    
    <?= $form->field($model, 'person')->label('Количество пассажиров') ->dropDownList(['1'=>'1', '2'=>'2','3'=>'3','4'=>'4'],['prompt' => 'Выберите один вариант']);  ?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>