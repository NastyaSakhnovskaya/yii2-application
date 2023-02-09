<?php

/** @var yii\web\View $this */
    use yii\widgets\Pjax;
    use yii\helpers\Url;
    use yii\web\UrlManager;
    use yii\bootstrap4\Modal;
?>
<?php Pjax::begin(); ?>
    <div class="account__block">
        <div class="account__menu">
            <a class="to_order" href="<?=Url::toRoute(['account/account', 'status' => 'active']);?>">Активные</a>
            <a class="to_order" href="<?=Url::toRoute(['account/account', 'status' => 'all']);?>">Все поездки</a>
            <a class="to_order" href="<?=Url::toRoute(['account/account', 'status' => 'cancel']);?>">Отмененные</a>
        </div>
        <div class="account__info">
            <?foreach($order as $Order):?>
                <div class="order__item">
                    <div class="details">
                        <div>
                            <p>Поездка оформлена на: <?=$Order['surname']?> <?=$Order['name']?></p>
                            <p>Номер телефона: <?=$Order['phone']?></p>
                        </div>
                        <?php
                            if($Order['status'] == "active"){
                        ?>
                        <a class="to_order" href="<?=Url::toRoute(['account/cancel', 'order_id' => $Order['order_id']]);?>">Отменить</a>
                        <?php
                            }
                        ?>
                    </div>
                    <p><b>Детали поездки:</b></p>
                    <div class="details">
                        <div>
                            <p>Дата: <?=$Order['date']?></p>
                            <p>Время: <?=$Order['time']?></p>
                            <p>Направление: <?=$Order['direction_from']?>-<?=$Order['direction_to']?></p>
                        </div>

                        <div>
                            <p>Транспорт: <?=$Order['brand']?></p>
                            <p>Цвет: <?=$Order['color']?></p>
                            <p>Номер: <?=$Order['bus_number']?></p>
                        </div>
                        <div>
                            <p>Водитель: <?=$Order['driver_surname']?> <?=$Order['driver_name']?></p>
                            <p>Номер телефона: <?=$Order['phone']?></p>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
<?php Pjax::end(); ?>