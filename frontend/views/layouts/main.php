<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\UrlManager;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="../../frontend/web/css/my_style.css">
</head>
<body class="d-flex flex-column h-100 body__class">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'АвтоЛайн',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {
        if(Yii::$app->user->identity->status == 10){
            $menuItems[] = ['label' => 'Поездки', 'url' => ['/account/index']];
        }
        if(Yii::$app->user->identity->username == "admin") {
            $menuItems = [
                ['label' => 'Водители', 'url' => ['/admindriver']],
                ['label' => 'Транспорт', 'url' => ['/adminbus']],
                ['label' => 'Маршруты', 'url' => ['/adminroutes']],
            ];
        }
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
</header>

<main role="main">
<img src="../../frontend/web/assets/img/background.jpg" class="my_container">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="hero__screen">
            <div class="container__screen">
                <h1>Поиск маршруток и автобусов</h2>
                <p class="screen__text">по Беларуси</p>
                <div class="hero__phone">
                    <p class="hero__phone__text">Если проще позвонить</p>
                    <p class="hero__phone__text">+375 29 3224921</p>
                </div>
                <?php
                    if(Yii::$app->user->identity->status == 10 || Yii::$app->user->isGuest){
                ?>
                    <div class="search">
                        <a class = "to_order search__but" href="<?=Url::toRoute('site/search');?>">Поиск</a>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted my__footer">
    <div class="container">
        <p class="float-left">&copy; АвтоЛайн <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
