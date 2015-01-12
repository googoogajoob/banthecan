<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
$this->title = 'Kanban Board';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-kanbanboard">
    <h1><?= Html::encode($this->title) ?></h1>

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

$testTicket = '<div style="background-color: #a8ddff; padding: 4px;"><strong>Test Ticket</strong><br />Andy<br /><br />Lassen wir etwas gut machen</div>';

$columnModel = [
    ['c1' =>$testTicket, 'c2' => '', 'c3' => $testTicket, 'c4' => '', 'c5' => ''],
    ['c1' =>'', 'c2' => $testTicket, 'c3' => $testTicket, 'c4' => '', 'c5' => ''],
    ['c1' =>'', 'c2' => $testTicket, 'c3' => '', 'c4' => '', 'c5' => ''],
    ['c1' =>'', 'c2' => '', 'c3' => $testTicket, 'c4' => '', 'c5' => $testTicket],
    ['c1' =>'', 'c2' => '', 'c3' => $testTicket, 'c4' => $testTicket, 'c5' => ''],
];

$dataProvider = new ArrayDataProvider([
    'allModels' => $columnModel,
    'sort' => false,
    'pagination' => false,
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'class' => 'table-striped',
    ],
    'columns' => [
         [
             'attribute' => 'c1',
             'format' => 'html',
         ],
         [
             'attribute' => 'c2',
             'format' => 'html',
         ],
         [
             'attribute' => 'c3',
             'format' => 'html',
         ],
         [
             'attribute' => 'c4',
             'format' => 'html',
         ],
         [
             'attribute' => 'c5',
             'format' => 'html',
         ],
    ],
]);
?>
</div>