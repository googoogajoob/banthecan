<?php

//use yii;
use yii\helpers\Html;
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
        <?php echo Html::csrfMetaTags() ?>
        <title>Ban the Can(<?= (YII_ENV_DEMO ? 'DEMO' : '') ?>): <?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>

    <?php echo $this->renderFile('@frontend/views/layouts/partials/_modalContainer.php'); ?>

    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php echo $this->renderFile('@frontend/views/layouts/partials/_navigation.php'); ?>

        <div class="container">
            <?php
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                echo Alert::widget();
                echo $content
            ?>
        </div>

    </div>

    <?php echo $this->renderFile('@frontend/views/layouts/partials/_footer.php'); ?>

    <?php $this->endBody() ?>

    </body>
    </html>
<?php $this->endPage() ?>