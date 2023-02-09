<?php

/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\web\UrlManager;
use yii\widgets\Pjax;

$this->title = 'АвтоЛайн';
?>
<?php
    if(Yii::$app->user->identity->status == 10 || Yii::$app->user->isGuest){
?>

<div class="main__content">
    <div class="container__screen">
        <h2>Популярные направления</h2>
        <div class="direction__block">
            <?foreach($routes as $Routes):?>
                <a class="direction__item" href="<?=Url::toRoute(['site/route', 'from' => $Routes->direction_from, 'to' => $Routes->direction_to]);?>">
                    <div class="direction__item__text">
                        <p><?=$Routes->direction_from?>-<?=$Routes->direction_to?></p>
                        <p><b><?=$Routes->price?> BYN</b></p>
                    </div>
                </a>
            <?endforeach;?>
        </div>
    </div>
</div>

<div class="about__block">
    <div class="container__screen center">
        <h2 class="hero__phone__text1">Заказывай быстрее и еще удобнее!</h2>
        <div class="about__content">
            <div class="about__text__block">
                <div class="about__text__item">
                    <h3>Экономия</h3>
                    <p>Технологии в основе АвтоЛайн увеличивают эффективность работы наших партнёров. Поэтому мы можем делать цены ниже.</p>
                </div>
                <div class="about__text__item">
                    <h3>Качество и контроль</h3>
                    <p>Мы контролируем работу водителей, состояние транспорта и работу сервиса. Мы неустанно трудимся над качеством услуг.</p>
                </div>
                <div class="about__text__item">
                    <h3>Возврат без проблем</h3>
                    <p>Вернем 100% стоимости в течение 12 часов при отмене поездки более чем за сутки до отправления.</p>
                </div>
            </div>
            <div class="about__img">
                <img src="../../frontend/web/assets/img/bus.png">
            </div>
        </div>
    </div>
</div>

<?php
    } else {

?>
<?php Pjax::begin(); ?>
<div class="main__content" style="margin-top: 100px">
    <div class="container__screen">
        <h2>Личные данные</h2>
        <p style="font-size:20px;">Водитель: <?=$driver->driver_surname?> <?=$driver->driver_name?></p>
        <p style="font-size:20px;">Телефон: <?=$driver->phone?></p>
        
<br><br>

        <h2>Список поездок</h2>

        <br><br>
        
            <div>
                <a class="to_order" href="<?=Url::toRoute(['site/index', 'type' => 'active'])?>">Активные поездки</a>
                <a class="to_order" href="<?=Url::toRoute(['site/index', 'type' => 'complete'])?>">Совершенные поездки</a>
            </div>
            <br>
            <div class="route__block">
                <div>
                    <?foreach($route as $Route):?>
                        <div class="direction__item route">
                            <div>
                                <p><b>
                                    <?php 
                                        $time = new DateTime($Route['time']);
                                        echo date_format($time, 'H:i');
                                    ?>
                                </b></p>
                                <p><?=$Route['direction_from']?></p>
                            </div>
                            <div>
                                <p><b>
                                    <?php 
                                        $time = new DateTime($Route['time']);
                                        if($Route['direction_from'] == 'Могилев' || $Route['direction_to'] == 'Могилев'){
                                            $time->add(new DateInterval('PT2H45M'));
                                        } else {
                                            $time->add(new DateInterval('PT2H'));
                                        }
                                        echo date_format($time, 'H:i');
                                    ?>
                                </b></p>
                                <p><?=$Route['direction_to']?></p>
                            </div>
                            <div>
                                <p><b><?=$Route['price']?> BYN</b></p>
                                <p>Свободно мест: <?=$Route['number_of_free_seats']?></p>
                            </div>

                            <?php 
                                if($Route['route_status'] == 'active') {
                            ?>
                                <a class="to_order" href="<?=Url::toRoute(['driver/index', 'route_id' => $Route['route_id']])?>">Подробнее</a>
                            <?php
                                } else {   
                            ?>
                                <a class="to_order no_seats" href="">Совершена</a>
                            <?php
                                }
                            ?>
                        </div>
                    <?endforeach;?>
                </div>
            </div>

    </div>
</div>
<?php Pjax::end(); ?>
<?php
    }
?>