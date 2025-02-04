<?php

/**
 * @var $this    yii\web\View
 * @var $content string
 */

use admin\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\{Breadcrumbs, Html, Nav, NavBar};
use kartik\icons\{FontAwesomeAsset, Icon};

AppAsset::register($this);
FontAwesomeAsset::register($this);

$galleries = \common\models\Galleries::find()->all(); // Получаем все галереи

$galleryMenuItems = [];

foreach ($galleries as $gallery) {
    $galleryMenuItems[] = [
        'label' => $gallery->title, // Название галереи
        'url' => ['/gallery-images', 'gallery_id' => $gallery->id],
    ];
}
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::$app->name ?> | Панель администратора</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => [
                'navbar',
                'navbar-light',
                'bg-light',
                'blue-grey',
                'tint-color-5',
                'navbar-fixed-top',
                'navbar-expand-lg'
            ]
        ]
    ]);

    $menuItems = [];

    if (!Yii::$app->user->isGuest) {
        $menuItems = [
            ['label' => 'Пользователи', 'url' => ['/user']],
            [
                'label' => 'Контент',
                'items' => [
                    //['label' => 'Тексты', 'url' => ['/text']],
                    ['label' => 'Квартиры', 'url' => ['/apartments']],
                    ['label' => 'Документы', 'url' => ['/documents']],
                    ['label' => 'Тексты', 'url' => ['/texts']],
                    ['label' => 'Галерея', 'url' => ['/galleries']],
                ]
            ],
            [
                'label' => 'Галерея',
                'items' => $galleryMenuItems,
            ],
            [
                'label' => 'Управление',
                'items' => [
                    ['label' => 'Настройки', 'url' => ['/setting']],
                    ['label' => 'Администраторы', 'url' => ['/user-admin']],
                    ['label' => 'Информация о хостинге', 'url' => ['/site/info']],
                ]
            ],
            '<li class="divider-vertical"></li>',
        ];
        $menuItems[] = Html::tag(
            'li',
            Html::a(
                sprintf('%sВыйти (%s) ', Icon::show('sign-out-alt'), Yii::$app->user->identity->username),
                ['/site/logout'],
                ['class' => 'nav-link', 'data-method' => 'POST']
            ),
            ['class' => 'nav-item skip-search']
        );
    } else {
        $menuItems[] = ['label' => Icon::show('sign-in-alt') . 'Войти', 'url' => ['/site/login']];
    }
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav ms-auto d-flex nav-pills justify-content-between'],
        'items' => $menuItems,
    ]);
    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? [],]) ?>

        <?= Alert::widget() ?>

        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

