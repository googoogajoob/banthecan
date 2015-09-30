<?php
/*
 * This view is a partial which is used by backlog and Completed.
 * It shows Ticket Widgets Free Floating Ticket Widgets
 * They are not contained within a column DIV element as with the KanBan Board
 * But are intended to occupy the entire screen or at least a large block area.
 */

use yii\helpers\Html;

/* @var $tickets common\models\Ticket */
?>

<div class="row">

<?php
foreach ($tickets as $ticket) {

    echo html::beginTag('div', ['class' => 'col-xs-2']);
    echo $this->render('@frontend/views/ticket/_ticketBlock', [
        'ticket' => $ticket,
        'divClass' => 'ticket-widget-float',
    ]);
    echo html::endTag('div');
}
?>

</div>
