<?php

use yii\helpers\Html;
use common\models\Board;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $action string */
/* @var $currentPageSize integer */
?>

<?php echo $this->render('@frontend/views/board/partials/_showSearchButton'); ?>

<h1 class="text-capitalize"><?php echo Board::getBoardSectionName('backlog'); ?></h1>
<span class="pull-left"><?php echo \Yii::t('app', 'Page Size:'); ?>&nbsp;</span>

<?php

echo Html::beginForm(Yii::$app->request->absoluteUrl, 'post', ['role' => 'form']);

echo Html::dropDownList(
    'per-page',
    $dataProvider->pagination->pageSize, [
        '6' => '6',
        '12' => '12',
        '24' => '24',
        '48' => '48',
        '96' => '96',
        '192' => '192',
    ],
    [
        'id' => 'backlog-per-page'
    ]
);

echo Html::endForm();

echo $this->render('@frontend/views/board/partials/_backlogAndCompleted', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'currentPageSize' => $currentPageSize,
    'action' => $action,
    'showPriority' => true,
]);