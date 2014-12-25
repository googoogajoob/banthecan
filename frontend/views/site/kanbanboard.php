<?php
use yii\helpers\Html;
//use yii\widgets; //This is not needed if the namespace is prepended to the class

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

// The "use" statement above is not need, when prepending, hmmm?

//$junk = new yii\widgets\DetailView();

$columnModel = array('key' => 'value');

echo yii\widgets\DetailView::widget([
    'model' => $columnModel,
    'attributes' => [
        'title',             // title attribute (in plain text)
        'description:html',  // description attribute in HTML
        [                    // the owner name of the model
            'label' => 'Owner',
            'value' => $columnModel['key'],
        ],
    ],
]);
?>
</div>