<?php

use yii\helpers\Html;
use frontend\assets\BoardAsset;

/* @var $this yii\web\View */
/* @var $columnHtml string */

// $this->params['breadcrumbs'][] = 'KanBanBoard';

// see http://stackoverflow.com/questions/5586558/jquery-ui-sortable-disable-update-function-before-receive
// for info about triggering the sortable events

BoardAsset::register($this);
?>

<h1 class="text-capitalize">
    <?php echo Html::encode($board->kanban_name) ?>
</h1>

<?php
    echo Html::hiddenInput('boardTimestamp', time(), ['id' => 'boardTimestamp']);
?>

<div id="kanban-row" class="row">
    <?php echo $columnHtml; ?>
</div>

