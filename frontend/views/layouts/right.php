<?php

//use yii;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Board;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
if ($boardObject = Board::getActiveBoard()) {
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
    <?= Html::csrfMetaTags() ?>
    <title>Ban the Can(<?= (YII_ENV_DEMO ? 'DEMO' : '') ?>): <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">

        <?php
            echo $this->renderFile('@frontend/views/layouts/partials/_navigation.php', ['boardObject' => $boardObject]);
            echo $this->renderFile('@frontend/views/layouts/partials/_right-sidebar.php');
        ?>

        <div id="layout-main" class="right-layout-main">

            <?php
                echo Html::icon('circle-arrow-right', [
                    'id' => 'toggle-right-sidebar',
                    'class' => 'pull-right apc-layout-toggle-button',
                ]);
            ?>

            <div class="container-fluid">
                <?php echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?php echo Alert::widget(); ?>

                <?php echo $content ?>
            </div>

        </div>

    </div>

    <?php echo $this->renderFile('@frontend/views/layouts/partials/_footer.php'); ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
