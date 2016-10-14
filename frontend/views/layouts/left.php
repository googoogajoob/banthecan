<?php

//use yii;
use yii\bootstrap\Html;
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
<?php echo $this->renderFile('@frontend/views/layouts/partials/_modalContainer.php'); ?>
<?php echo $this->renderFile('@frontend/views/layouts/partials/_navigation.php'); ?>

<div class="wrap">
    <div id="layout-main">
        <div class="container-fluid">
            <?php echo Alert::widget(); ?>

            <button
                id="show-search-option-button"
                type="button"
                class="btn btn-default btn-primary"
                data-toggle="collapse"
                data-target="#left-sidebar"
                aria-controls="left-sidebar"
                aria-expanded="false">
                <?php echo \Yii::t('app', 'Show Search Options'); ?>
            </button>

            <button
                id="hide-search-option-button"
                type="button"
                class="btn btn-default btn-primary hidden"
                data-toggle="collapse"
                data-target="#left-sidebar"
                aria-controls="left-sidebar"
                aria-expanded="false">
                <?php echo \Yii::t('app', 'Hide Search Options'); ?>
            </button>

            <div class="row">

                <div id="left-sidebar" class="collapse width">
                    <div class="col-xs-6 col-sm-4 col-lg-2">
                        Junk
                        <?php //echo $this->renderFile('@frontend/views/ticket/partials/_backlogTicketSearchForm.php'); ?>

                    </div>
                </div>

                <div id="left-layout-main" class="col-xs-12">
                    <?php echo $content ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo $this->renderFile('@frontend/views/layouts/partials/_footer.php'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
