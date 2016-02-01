<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BoardColumn */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Board Columns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-column-view">

<h1><?= Html::encode($this->title) ?></h1>

<p><?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
],
]) ?></p>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'board_id',
            'title:ntext',
            'display_order',
            'receiver',
[
                'label' => \Yii::t('app', 'Ticket Column Configuration'),
                'value' => implode(', ', $model->ticket_column_configuration),
],
],
]) ?></div>
