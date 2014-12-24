<?php
use yii\helpers\Html;

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


$kanbancolumn = '<div style="' . $columnStyle . '">This is a column';
for($i=0; $i<4; $i++) {
    $kanbancolumn .= '<div style="' . $ticketStyle . '">This is a Ticket' . '</div>';
}
$kanbancolumn .= '</div>';
for($i=0; $i<5; $i++) {
    echo $kanbancolumn;
}
?>
</div>