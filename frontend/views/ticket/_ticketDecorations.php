<?php

use common\models\ticketDecoration\TicketDecorationInterface;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */

//Ticket Decoration Bar displays the Ticket decorations

foreach ($ticket->getBehaviors() as $ticketBehavior) {
    if ($ticketBehavior instanceof TicketDecorationInterface) {
        echo $ticketBehavior->show();
    }
}
?>