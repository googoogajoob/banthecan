<?php

use common\models\ticketDecoration\TicketDecorationInterface;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $showDiv boolean */

//Ticket Decoration Bar displays the Ticket decorations

    if ($showDiv) {
        echo Html::beginTag('div', ['class' => 'ticket-single-decorations']);
    }

    foreach ($model->getBehaviors() as $ticketBehavior) {
        if ($ticketBehavior instanceof TicketDecorationInterface) {
            echo Html::beginTag('div', ['class' => 'ticket-single-decorations-glyph']);
            echo $ticketBehavior->show();
            echo Html::endTag('div');
        }
    }

    if ($showDiv) {
        echo Html::endTag('div');
    }

?>