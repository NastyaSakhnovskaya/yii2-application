<?php
    use yii\helpers\Url;
    use yii\widgets\Pjax;
    use yii\web\UrlManager;
?>
<?php Pjax::begin(); ?>
    <div class="route__block" style="margin-top:250px">

        <div class="people--left">
            <?foreach($people as $people):?>
                <div class="direction__item route">
                    <div>
                        <p>Пассажир: <?=$people->surname?> <?=$people->name?></p>
                        <p>Телефон: <?=$people->phone?></p>
                        <p>Количество пассажиров: <?=$people->number_of_seats?></p>
                    </div>
                    <?php
                        if($people->status == 'active'){

                    ?>
                        <div>
                            <a class="btn btn-success" href="<?=Url::toRoute(['driver/check', 'type' => 'yes', 'order_id'=>$people->order_id, 'route_id'=>Yii::$app->request->get()['route_id']]);?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill-rule="evenodd" d="M21.03 5.72a.75.75 0 010 1.06l-11.5 11.5a.75.75 0 01-1.072-.012l-5.5-5.75a.75.75 0 111.084-1.036l4.97 5.195L19.97 5.72a.75.75 0 011.06 0z"></path></svg></a>
                            <a class="btn btn-danger" href="<?=Url::toRoute(['driver/check', 'type' => 'no', 'order_id'=>$people->order_id, 'route_id'=>Yii::$app->request->get()['route_id']]);?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill-rule="evenodd" d="M5.72 5.72a.75.75 0 011.06 0L12 10.94l5.22-5.22a.75.75 0 111.06 1.06L13.06 12l5.22 5.22a.75.75 0 11-1.06 1.06L12 13.06l-5.22 5.22a.75.75 0 01-1.06-1.06L10.94 12 5.72 6.78a.75.75 0 010-1.06z"></path></svg></a>
                        </div>
                    <?php
                        }else {
                            if($people->status == 'yes'){
                    ?>
                        <div>
                            <a class="btn btn-outline-secondary" href="">Посадка совершена</a>
                        </div>
                    <?php
                        } else{
                    ?>
                        <div>
                            <a class="btn btn-outline-secondary" href="">Посадка не совершена</a>
                        </div>
                    <?php
                        }
                    ?>
                        
                    <?php      
                        }
                    ?>
                </div>
                <?php
                    if($people->status == 'yes'){
                        $sum += $people->number_of_seats * 10;
                    }
                ?> 
            <?endforeach;?>
        </div>

        <div class="direction__item people--right">
            <div style="margin-bottom: 20px;">
                <p>Итоговая сумма:</p>
                <p><?=$sum?> BYN</p>
                <p>Статус поездки:</p>
                <a class="sort_item" href="<?=Url::toRoute(['driver/change', 'route_id'=>Yii::$app->request->get()['route_id']]);?>">Поездка совершена</a>
            </div>
        </div>
    </div>
<?php Pjax::end(); ?>
