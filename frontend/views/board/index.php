<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\jui\Sortable;

/* @var $this yii\web\View */
$this->params['breadcrumbs'][] = 'KanBanBoard';
?>

<div class="site-kanbanboard">
    <h1><?= Html::encode($board->title) ?></h1>
    <small><em><?= Html::encode($board->description) ?></em></small>
    <div id="info"></div>

    <?php
        //todo: this needs to be cleaned up, html::<methods> or something else that is really slick (elegant)
        echo '<div>';
            foreach($board->getColumns() as $column) {
                echo '<div>';
                    echo $column->title;
                    foreach($column->getTickets() as $ticket) {
                        echo '>' . $ticket->title . '(' . $ticket->created_by. '): ' . $ticket->description . '<br />';
                    }
                echo '</div>';
            }
        echo '</div>';

/*    //initialize gridRow array
    foreach ($columnData as $column) {
        $gridRow[$column['attribute']] = [];
    }

    //fill grid row array with tickets
    foreach ($ticketData as $ticketRecord) {
        $widgetId = 'ticketwidget_'. $ticketRecord['id'];
        $gridRow[$ticketRecord['columnId']][] = [
            'content' => $this->render('../ticket/_ticketBlock', ['ticketRecord' => $ticketRecord]),
            'options' => [
                'id' => $widgetId,
                'tag' => 'div',
                'class' => 'ticket-widget',
            ],
        ];
    }

    // Wrap gridRow column contents into a sortable div element.
    // see http://stackoverflow.com/questions/5586558/jquery-ui-sortable-disable-update-function-before-receive
    // for info about triggering the events
    foreach ($columnData as $column) {
        $cIndex = $column['attribute'];
        $displayOrder = $column['displayOrder'];
        $gridRow[$cIndex] = Sortable::widget([
            'items' => $gridRow[$cIndex],
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
    }

    $dataProvider = new ArrayDataProvider([
        'allModels' => [$gridRow],
        'sort' => false,
        'pagination' => false,
    ]);

    // create Column Data array compatible for consumption by GridView
    // column data and ticket data are related but processed separately
    foreach ($columnData as $column) {
        $gridColumn[] = [
            'attribute' => $column['attribute'],
            // need to learn how to purify HTML but allow the ID,I18N formatter, purifier causes problems
            // somehow somewhere it needs to be configured
            'format' => 'raw', //When USing HTML the ID attribute is removed by the purifier, bad news for Draggable
            'label' => $column['title'],
            'contentOptions' => ['valign' => 'top'],
        ];
    }

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '', //removes total count at the top
        'tableOptions' => [
            'class' => 'table-striped',
        ],
        'columns' => $gridColumn,
    ]); */

    ?>
</div>