<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use frontend\assets\BanTheCanAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
BanTheCanAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Ban the Can - FRONTEND',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            if (Yii::$app->user->isGuest) {

                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
                $menuItems[] = ['label' => 'Contact', 'url' => ['/site/contact']];
                $menuItems[] = ['label' => 'About', 'url' => ['/site/about']];

            } else {

                $menuItems = [
                    ['label' => 'Tickets', 'url' => ['/ticket']],
                    ['label' => 'Boards',
                        'items' => [
                            ['label' => 'Backlog', 'url' => ['/board/backlog']],
                            ['label' => 'Board', 'url' => ['/board']],
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

    <?php
    $session = Yii::$app->session;
    foreach ($session as $name => $value) {
        echo "$name -> " . print_r($value, true) . "<br/>";
    }
    $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
