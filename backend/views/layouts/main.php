<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\models\User;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= (YII_ENV_DEMO ? 'DEMO: ' : '') ?>Ban-The-Can Admin</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => (YII_ENV_DEMO ? 'DEMO: ' : '') . 'Ban-The-Can Admin',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        // If in Demo Mode only show login when a demo user exists, otherwise if snx users exist

        if (YII_ENV_DEMO) {
            $showLogin = (bool)User::findDemoUser();
        } else {
            $showLogin = (bool)(User::count() > 0);
        }

        $menuItems = [
            [
                'label' => 'Login',
                'url' => ['/site/login'],
                'visible' => $showLogin,
            ],
            [
                'label' => 'Create Initial Admin User',
                'url' => ['/site/create'],
                'visible' => !YII_ENV_DEMO && !$showLogin,
            ],
        ];

        if (YII_ENV_DEMO && !$showLogin) {
            $session = Yii::$app->session;
            $session->setFlash('info',
                \Yii::t('app', 'A Demo User does not exist. You must <a href="/site/initialize"><strong>initialize</strong></a> the Demo Database from the menu. After this you will be automatically logged in as a <strong>demo</strong> user.'));
        }


    } else {
        $menuItems = [
            ['label' => \Yii::t('app', 'Home'), 'url' => ['/site/index']],
            ['label' => \Yii::t('app', 'Boards'), 'url' => ['/board/index']],
            ['label' => \Yii::t('app', 'Columns'), 'url' => ['/column/index']],
            ['label' => \Yii::t('app', 'Tickets'), 'url' => ['/ticket/index']],
            ['label' => \Yii::t('app', 'Users'), 'url' => ['/user/index']],
            ['label' => \Yii::t('app', 'Action'), 'url' => ['/actionstep/index']],
            ['label' => \Yii::t('app', 'Resolution'), 'url' => ['/resolution/index']],
            ['label' => \Yii::t('app', 'News'), 'url' => ['/sitenews/index']],
            [
                'label' => \Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ],
        ];
    }

    $menuItems[] = [
        'label' => \Yii::t('app', 'Initialize Demo Database'),
        'url' => ['/site/initialize'],
        'linkOptions' => ['title' => \Yii::t('app', 'Create a fresh demo database including a demo user')],
        'visible' => YII_ENV_DEMO,
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php echo Alert::widget(); ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
