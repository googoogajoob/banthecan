<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-kanbanboard">
    <h1><?= Html::encode($boardTitle) ?></h1>
    <small><em><?= Html::encode($boardDescription) ?></em></small>
    <hr/>

    <?php
    // Create HTML Div Element for each Ticket using $columnId as an index to the column
    // Tickets are appended to one another and together comprise the contents of one table cell
    // Therefore they need to be appended to one another as they are evaluated in the loop
    // However, in the loop they can come in random order
    $gridRow = [];
    foreach ($ticketData as $ticket) {
        $newTicket = $this->render('../ticket/_ticket', ['ticket' => $ticket]);
        // The .= operator complains if the array element is not defined
        // Therefore if NOT defined create it first
        if (array_key_exists($ticket['columnId'], $gridRow)) {
            $gridRow[$ticket['columnId']] .= $newTicket;
        } else {
            $gridRow[$ticket['columnId']] = $newTicket;
        }
    }
    $columnTickets[] = $gridRow;

    // create Column Data array compatible for consumption by GridView
    foreach ($columnData as $column) {
        $gridColumn[] = [
            'attribute' => $column['attribute'],
            'format' => 'html',
            'label' => $column['title'],
            'contentOptions' => ['valign' => 'top'],
        ];
    }

    $dataProvider = new ArrayDataProvider([
        'allModels' => $columnTickets,
        'sort' => false,
        'pagination' => false,
    ]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '', //removes total count at the top
        'tableOptions' => [
            'class' => 'table-striped',
        ],
        'columns' => $gridColumn,
    ]);
    ?>
</div>