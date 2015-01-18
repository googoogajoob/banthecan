<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
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
    $columnStyle = '
    width: 200px;
    height: 600px;
    background-color: lightgray;
    border-style: solid;
    border-color: black;
    border-width: 1px;
    margin: 10px;
    padding: 5px;
    float: left;';

    $ticketStyle = '
    width: 188px;
    height: 100px;
    background-color: #fff;
    border-style: solid;
    border-color: blue;
    border-width: 1px;
    padding: 5px;
    margin-bottom: 4px;
    float: left;';

    // Create HTML Div Element for each Ticket using $columnId as an index to the column
    // Tickets are appended to one another and together comprise the contents of one table cell
    // Therefore they need to be appended to one another as they are evaluated in the loop
    // However, in the loop they can come in random order
    $gridRow = [];
    foreach ($ticketData as $ticket) {

        $newTicket =
            '<div style="background-color: #cdebff; width: 180px; height: 230px;padding: 4px; margin: 8px 4px;"><strong>' .
            $ticket['title'] .
            '</strong><br />' . $ticket['assignedName'] . '<br />' .
            Yii::$app->formatter->asDate($ticket['created'], 'long') . '<br /><br />' .
            StringHelper::truncate($ticket['description'], 100, ' ...') .
            '</div>';

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