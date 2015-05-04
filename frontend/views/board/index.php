<?php

use yii\helpers\Html;
use frontend\assets\BoardAsset;

/* @var $this yii\web\View */
$this->params['breadcrumbs'][] = 'KanBanBoard';

// see http://stackoverflow.com/questions/5586558/jquery-ui-sortable-disable-update-function-before-receive
// for info about triggering the sortable events

BoardAsset::register($this);
?>

<div id="info">This is the info Div-Block. Do I really need this here?
 It's possible this is taken care of in the main layout. On the other hand somebody put this here for a reason
    (it wasn't me) abd I'd like to know what it was. </div>

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

