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

$columnModel = [
    ['name' =>'Andy', 'birthday' => 145],
    ['name' =>'Ringo', 'birthday' => 21],
];

$dataProvider = new ArrayDataProvider([
    'allModels' => $columnModel,
    'sort' => false,
    'pagination' => false,
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => ['name', 'birthday'],
]);
?>
</div>