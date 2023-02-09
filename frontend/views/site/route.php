<?php

/** @var yii\web\View $this */
    use yii\widgets\Pjax;
    use yii\helpers\Url;
    use yii\web\UrlManager;
    use yii\bootstrap4\Modal;
?>
<?php Pjax::begin(); ?>
    <div class="date__block">
        <?php 
            $date = new DateTime();
            $from = Yii::$app->request->get()['from'];
            $to = Yii::$app->request->get()['to'];
            for( $i = 1; $i < 7; $i++) {
        ?>
            <div class="direction__item date">
                <a class="href" href="<?=Url::toRoute(['site/route', 'from' => $from, 'to' => $to, 'date' => $date->format('Y-m-d')]);?>">
                    <?php echo $date->format('j F Y');?>
                </a>
            </div>
        <?php
                $date->add(new DateInterval('P1D'));
            }
        ?>
    </div>

    <div class="route__block">
        <div>
            <?
                foreach($route as $Route):
                    if($Route['route_status'] == 'active'){
            ?>
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
                        if($Route['number_of_free_seats'] == 0) {
                    ?>
                    <a class="to_order no_seats" href="">Нет мест</a>
                    <?php
                        } else {
                            if(!Yii::$app->user->isGuest) {    
                    ?>
                    <a class="to_order" href="<?=Url::toRoute(['route/order', 'order_id' => $Route['route_id']])?>">Заказать</a>
                    <?php
                            } else {
                                
                                Modal::begin([
                                    'title' => 'Предупреждение',
                                    'toggleButton' => [
                                        'label' => 'Заказать',
                                        'class' => "to_order"
                                    ],
                                    
                                ]);
                                
                                echo 'Заказать маршрутку могут только зарегистрированные и авторизированные пользователи.';
                                
                                Modal::end();
                            }
                        }
                    ?>
                    
                </div>
            <?
                }
                endforeach;
            ?>
        </div>

        <div class="direction__item sort">
            <div style="margin-bottom: 20px;">
                <p>Сортировать по времени</p>
                <a class="sort_item" href="<?=Url::current(['time' => 'morning']);?>">утро</a>
                <a class="sort_item" href="<?=Url::current(['time' => 'day']);?>">день</a>
                <a class="sort_item" href="<?=Url::current(['time' => 'evening']);?>">вечер</a>
            </div>
            <div>
                <p>Сортировать по количеству свободных мест</p>
                <a class="sort_item" href="<?=Url::current(['order' => 'asc']);?>">по возрастанию</a><br><br>
                <a class="sort_item" href="<?=Url::current(['order' => 'desc']);?>">по убыванию</a>
            </div>
        </div>
    </div>
<?php Pjax::end(); ?>