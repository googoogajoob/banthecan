<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $column common\models\Column */

?>

<div class="col-xs-2">
    <?php
        echo Html::beginTag('h4');
        echo $column->title;
        echo Html::endTag('h4');
        foreach($column->getTickets() as $ticket) {
            echo Html::beginTag('div', ['class' => 'ticket-widget']);
            echo $this->render('@frontend/views/ticket/_ticketBlock', ['ticket' => $ticket]);
            echo Html::endTag('div');
        }
    ?>
</div>

