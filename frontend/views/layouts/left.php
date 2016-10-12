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
    <?= Html::csrfMetaTags() ?>
    <title>Ban the Can(<?= (YII_ENV_DEMO ? 'DEMO' : '') ?>): <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php echo $this->renderFile('@frontend/views/layouts/partials/_modalContainer.php'); ?>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
        echo $this->renderFile(
            '@frontend/views/layouts/partials/_navigation.php', [
                'boardObject' => $boardObject,
                'kanbanName' => $kanbanName,
                'backlogName' => $backlogName
            ]
        );
        echo $this->renderFile('@frontend/views/layouts/partials/_left-sidebar.php');
    ?>

    <div id="layout-main" class="left-layout-main">
        <?php
            echo Html::icon('circle-arrow-left', [
                'id' => 'toggle-left-sidebar',
                'class' => 'pull-left apc-layout-toggle-button'
            ]);
        ?>
        <div class="container-fluid">
            <?php
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                echo Alert::widget();
                echo $content
            ?>
        </div>
    </div>
</div>

<?php echo $this->renderFile('@frontend/views/layouts/partials/_footer.php'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
