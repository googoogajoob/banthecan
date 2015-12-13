<?php

use common\models\ticketDecoration\TicketDecorationInterface;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */

//Ticket Decoration Bar displays the Ticket decorations

foreach ($ticket->getBehaviors() as $ticketBehavior) {
    if ($ticketBehavior instanceof TicketDecorationInterface) {
        echo Html::beginTag('div', ['class' => 'ticket-single-decorations-glyph']);
        echo $ticketBehavior->show();
        echo Html::endTag('div');
    }
}
?>