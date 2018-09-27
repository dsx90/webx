<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\models\NavItem;
use lo\modules\noty\Wrapper;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('frontend', 'Articles'), 'url' => ['/article/index']],
        [
            'label' => Yii::t('frontend', 'Users'),
            'url' => ['/account/default/users'],
            'visible' => !Yii::$app->user->isGuest,
        ],
        ['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('frontend', 'Login'), 'url' => ['/account/sign-in/login']];
    } else {
        $menuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'url' => '#',
            'items' => [
                ['label' => Yii::t('frontend', 'Settings'), 'url' => ['/account/default/settings']],
                [
                    'label' => Yii::t('frontend', 'Backend'),
                    'url' => env('BACKEND_URL'),
                    'linkOptions' => ['target' => '_blank'],
                    'visible' => Yii::$app->user->can('administrator'),
                ],
                [
                    'label' => Yii::t('frontend', 'Logout'),
                    'url' => ['/account/sign-in/logout'],
                    'linkOptions' => ['data-method' => 'post'],
                ],
            ],
        ];
    }
    ?>
    <div class="contacts">
        <div class="contact-bl">
            <div class="phone">
                8(123) <span class="number">456-78-91</span>
            </div>
        </div>

        <?= Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => ArrayHelper::merge(NavItem::getMenuItems(), $menuItems),
        ]);
        ?>
    </div>

    <? NavBar::end() ?>

    <div class="container">

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Wrapper::widget() ?>
        <div class="row">
            <?= $content ?>
        </div>
    </div>
</div>

<div class="container-fluid icon-4" style="background: url(/images/site/proje_cizimi.jpg) no-repeat; background-position: bottom;">
    <div class="container">
        <center>
            <h2>Почему нам доверяют</h2>
            <i class="fa fa-angle-double-down" aria-hidden="true" style="font-size: 50px"></i>
        </center>
        <div class="col-sm-3">
            <center>
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <p>Делаем все в срок или выплачиваем вам по 5 000 руб. за каждый день просрочки</p>
            </center>
        </div>
        <div class="col-sm-3">
            <center>
                <i class="fa fa-key" aria-hidden="true"></i>
                <p>Выполняем работы от эскиза до сдачи “под ключ”</p>
            </center>
        </div>
        <div class="col-sm-3">
            <center>
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                <p>Соблюдаем все стандарты строительства (СНиП, ГОСТ, СанПиН)</p>
            </center>
        </div>
        <div class="col-sm-3">
            <center>
                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                <p>Минимальные сроки строительства — от 4-х недель</p>
            </center>
        </div>

    </div>
</div>
<div class="callback">
    <div class="container" style="width: 500px;">
        <div class="front side">
            <div class="content">
                <h1>Hakkam Абдулла</h1>
                <p>Я графический дизайнер и арт-директор. Я также специализируется на интерфейсных веб-дизайн, пользовательский опыт и создания личности. На протяжении всей моей карьеры, я работал с компаний всех форм и размеров, которые обогатили мой опыт
                </p>
            </div>
        </div>
        <div class="back side">
            <div class="content">
                <h1>Свяжитесь Со Мной</h1>
                <form>
                    <label>Ваше имя :</label>
                    <input type="text" placeholder="Омар Хаттаб">
                    <label>Ваша Электронная почта :</label>
                    <input type="text" placeholder="Example@mail.com">
                    <label>Ваше сообщение :</label>
                    <textarea placeholder="Предмет"></textarea>
                    <input type="submit" value="Сделано">
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
