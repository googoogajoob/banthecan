<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Column */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Columns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?php
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'boardTitle',
                'title:ntext',
                'display_order',
                'receiverList',
                [
                    'label' => \Yii::t('app', 'Ticket Column Configuration'),
                    'value' => implode(', ', $model->ticket_column_configuration),
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]);
    ?>
</div>
