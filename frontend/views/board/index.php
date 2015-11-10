<?php

use yii\helpers\Html;
use frontend\assets\BoardAsset;
use common\models\Ticket;

/* @var $this yii\web\View */
/* @var $board common\models\Board */

// $this->params['breadcrumbs'][] = 'KanBanBoard';

// see http://stackoverflow.com/questions/5586558/jquery-ui-sortable-disable-update-function-before-receive
// for info about triggering the sortable events

BoardAsset::register($this);

$model = Ticket::findOne(3393);
$this->beginBlock('right-sidebar');

echo $this->render('@frontend/views/ticket/view',[
'model' => $model,
]);

$this->endBlock();
?>

<h1 class="text-capitalize">
    <?php echo Html::encode($board->kanban_name) ?>
</h1>

<p class="bg-warning">
    <small><em><?= Html::encode($board->description) ?></em></small>
</p>

<div class="row">
    <?php
        foreach($board->getColumns() as $column) {
            echo $this->render('@frontend/views/board/_column', ['column' => $column]);
        }
    ?>
</div>

