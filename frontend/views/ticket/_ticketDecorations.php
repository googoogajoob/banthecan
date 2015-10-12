<?php

use yii\helpers\Html;
use common\models\ticketDecoration\TicketDecorationInterface;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */

//Ticket Decoration Bar displays the Ticket decorations
echo Html::beginTag('div', ['class' => 'ticket-single-decorations']);

foreach ($ticket->getBehaviors() as $ticketBehavior) {
  if ($ticketBehavior instanceof TicketDecorationInterface) {
    echo $ticketBehavior->show();
  }
}

echo Html::endTag('div');
?>