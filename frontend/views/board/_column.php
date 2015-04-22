<?php

use yii\helpers\Html;
use yii\jui\Sortable;

/* @var $this yii\web\View */
/* @var $column common\models\Column */

?>

<!-- div class="col-xs-2" -->

    <!-- h4> <?php echo $column->title; ?> </h4 -->

    <?php
        //$columnHeader = html::beginTag('h4') . $column->title . html::endTag('h4');

        // Get the HTML of all ticket content for this column concatenated into one string
        $columnItems = [];
        foreach($column->getTickets() as $ticket) {
            $content = $this->render('@frontend/views/ticket/_ticketBlock',[
                'ticket' => $ticket,
                'divWrapper' => false,
            ]);
            $options = [
                'id' => 'ticketwidget_'. $ticket->id,
                'tag' => 'div',
                'class' => 'ticket-widget',
            ];
            $columnItems[] = [
                'content' => $content,
                'options' => $options,
            ];
        }

        //create the column as a sortable widget
        echo Sortable::widget([
            'items' => $columnItems,
            'options' => ['id' => 'boardColumn_' . $column->id, 'tag' => 'div', 'class' => 'col-xs-2'],
            'clientOptions' => [
                'cursor' => 'move',
                'connectWith' => ($column->display_order != 4 ? '#boardColumn_' . ($column->display_order + 1) : '#boardColumn_1'),
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

<!-- /div -->

