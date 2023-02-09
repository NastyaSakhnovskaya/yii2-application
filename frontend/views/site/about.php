<?php
use yii\helpers\Html;
?>
<p>Вы ввели следующую информацию:</p>
<ul>
 <li><label>Name</label>: <?= Html::encode($model->from) ?></li>
 <li><label>Email</label>: <?= Html::encode($model->to) ?></li>
</ul>