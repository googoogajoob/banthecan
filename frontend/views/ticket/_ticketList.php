<?php
/*
 * This view is a partial which is used by backlog and Completed to
 * It shows Ticket Widgets Free Floating not contained within a column as on the KanBanBoard
 */
use yii\helpers\Html;

/* @var $tickets common\models\Ticket */

foreach ($tickets as $ticket) {
    echo Html::beginTag('div', ['class' => 'ticket-widget-float']);
    echo $this->render('@frontend/views/ticket/_ticketBlock', [
        'ticketRecord' => $ticket,
    ]);
    echo Html::endTag('div');
}
?>
