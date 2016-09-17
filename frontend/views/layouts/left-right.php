<?php

//use yii;
use yii\bootstrap\Html;
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
if ($boardObject = Board::getActiveBoard()) {
    $this->title = $boardObject->title;
    $kanbanName = trim($boardObject->kanban_name) == '' ? \Yii::t('app', 'Kanban') : $boardObject->kanban_name;
    $backlogName = trim($boardObject->backlog_name) == '' ? \Yii::t('app', 'Backlog'): $boardObject->backlog_name;
} else {
    $this->title = '';
    $kanbanName = \Yii::t('app', 'Kanban');
    $backlogName = \Yii::t('app', 'Backlog');
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

<div class="wrap"><?php
    echo $this->renderFile(
        '@frontend/views/layouts/partials/_navigation.php', [
            'boardObject' => $boardObject,
            'kanbanName' => $kanbanName,
            'backlogName' => $backlogName
        ]
    );
    echo $this->renderFile('@frontend/views/layouts/partials/_left-sidebar.php');
    echo $this->renderFile('@frontend/views/layouts/partials/_right-sidebar.php');
    ?>


    <div id="layout-main" class="left-right-layout-main"><?php
        echo Html::icon('circle-arrow-left', [
            'id' => 'toggle-left-sidebar',
            'class' => 'pull-left apc-layout-toggle-button'
        ]);
        echo Html::icon('circle-arrow-left', [
            'id' => 'toggle-right-sidebar',
            'class' => 'pull-right apc-layout-toggle-button visible-lg-block',
        ]);
        ?>

        <div class="container-fluid"><?php
            echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
            ?><?php echo Alert::widget(); ?><?php echo $content ?></div>

    </div>
</div>

<?php echo $this->renderFile('@frontend/views/layouts/partials/_footer.php'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
