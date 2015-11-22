<?php

//use yii;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Board;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
if ($boardObject = Board::getActiveboard()) {
    $this->title = $boardObject->title;
} else {
    $this->title = '';
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <title>Ban the Can(<?= (YII_ENV_DEMO ? 'DEMO' : '') ?>): <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">

        <?php
            NavBar::begin([
                'brandLabel' => (YII_ENV_DEMO ? 'DEMO: ' : '') . $this->title,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
                'innerContainerOptions' => [
                    'class' => 'container-fluid'
                ]
            ]);

            if (Yii::$app->user->isGuest) {

                //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
                $menuItems[] = ['label' => 'Contact', 'url' => ['/site/contact']];
                $menuItems[] = ['label' => 'About', 'url' => ['/site/about']];

            } else {

                $menuItems = [
                    ['label' => 'Tags', 'url' => ['/tags']],
                    ['label' => 'Tickets', 'url' => ['/ticket']],
                    ['label' => 'Boards', 'visible' => (boolean) $boardObject,
                        'items' => [
                            ['label' => 'Backlog', 'url' => ['/board/backlog']],
                            ['label' => 'KanBan', 'url' => ['/board']],
                            ['label' => 'Completed', 'url' => ['/board/completed']],
                        ],
                    ],
                ];

                $menuItems[] = html::tag('li',
                        $this->render('../site/_userIcon',['userId' => Yii::$app->getUser()->id]),
                        ['class' => 'menu-avatar-li']);

                $menuItems[] = ['label' => '', 'items' => [
                        ['label' => 'Select Board', 'url' => ['/board/select']],
                        ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                        ['label' => 'About', 'url' => ['/site/about']],
                        ['label' => 'Contact', 'url' => ['/site/contact']]
                    ],
                ];
            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);

            echo Button::widget([
                'label' => 'Create Ticket',
                'options' => [
                    'class' => 'btn-primary apc-header-button',
                    'id' => 'header-create-button',
                ]
            ]);

            echo Button::widget([
                'label' => 'Backlog',
                'options' => [
                    'class' => 'btn-primary apc-header-button',
                    'id' => 'header-backlog-button',
                ]
            ]);

            echo Button::widget([
                'label' => 'Kanban',
                'options' => [
                    'class' => 'btn-primary apc-header-button',
                    'id' => 'header-kanban-button',
                ]
            ]);

            echo Button::widget([
                'label' => 'Completed',
                'options' => [
                    'class' => 'btn-primary apc-header-button',
                    'id' => 'header-completed-button',
                ]
            ]);

            NavBar::end();
        ?>

        <div class="container">
            <?php echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?php echo Alert::widget(); ?>
            <?php echo $content ?>
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