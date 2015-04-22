<?php

use yii\jui\Sortable;

/* @var $this yii\web\View */
/* @var $column common\models\Column */

?>

<div class="col-xs-2">

    <h4> <?php echo $column->title; ?> </h4>

    <?php
        $columnItems = '';
        foreach($column->getTickets() as $ticket) {
            $columnItems .= $this->render('@frontend/views/ticket/_ticketBlock',[
                'ticket' => $ticket,
                'divClass' => 'ticket-widget'
            ]);
        }

        $displayOrder = $column->display_order;
        echo Sortable::widget([
            'items' => $columnItems,
            'options' => ['id' => 'boardColumn_' . $cIndex, 'tag' => 'div', 'class' => 'board-column'],
            'clientOptions' => [
                'cursor' => 'move',
                'connectWith' => ($displayOrder != 4 ? '#boardColumn_' . ($displayOrder + 1) : '#boardColumn_1'),
            ],
            'clientEvents' => [
                'receive' => 'function (event, ui) {
                    columnTicketOrder(event, ui, this);
                }',
                'update' => 'function (event, ui) {
                    if (!ui.sender && this === ui.item.parent()[0]) {
                       columnTicketOrder(event, ui, this);
                    }
                }',
            ],
        ]);
    ?>

</div>

