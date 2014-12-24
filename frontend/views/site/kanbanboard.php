<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Kanban Board';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-kanbanboard">
    <h1><?= Html::encode($this->title) ?></h1>
<?php
$css = 'width: 200px;
        height: 600px;
        border-style: solid;
        border-color: black;
        margin: 10px;
        padding: 1em;
        float: left;';
$kanbancolumn = '<div style="' . $css . '">This is a column</div>';
for($i=0; $i<5; $i++) {
    echo $kanbancolumn;
}
?>
</div>