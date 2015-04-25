<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\jui\Sortable;

/* @var $this yii\web\View */
$this->params['breadcrumbs'][] = 'KanBanBoard';

// see http://stackoverflow.com/questions/5586558/jquery-ui-sortable-disable-update-function-before-receive
// for info about triggering the sortable events
?>

<div id="info"></div>

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
