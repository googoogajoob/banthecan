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
    <hr />

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

$testTicket = '<div style="background-color: #a8ddff; padding: 4px; margin: 8px 4px;"><strong>Test Ticket</strong><br />Andy<br /><br />Lassen wir etwas gut machen</div>';

$columnModel = [
    [
        'c1' => $testTicket . $testTicket . $testTicket . $testTicket,
        'c2' => $testTicket . $testTicket,
        'c3' => $testTicket,
        'c4' => $testTicket . $testTicket . $testTicket,
        'c5' => $testTicket . $testTicket . $testTicket . $testTicket . $testTicket . $testTicket,
    ],
];

$columnCounter = 1;
foreach($columnName as $name) {
    $gridColumn[] = [
        'attribute' => 'c' . $columnCounter,
        'format' => 'html',
        'label' => $name,
        'contentOptions' => ['valign' => 'top'],
    ];
    $columnCounter++;
}

$dataProvider = new ArrayDataProvider([
    'allModels' => $columnModel,
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