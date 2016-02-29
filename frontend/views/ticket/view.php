<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Tickets'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?php
        echo Html::a(\Yii::t('app', 'Edit'), ['/ticket/update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        echo Html::a(\Yii::t('app', 'Delete'), ['/ticket/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]);
    ?>
</p>

<?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'title',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Title'),
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Description'),
            ],
            [
                'attribute' => 'protocol',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Protocol'),
            ],
            [
                'attribute' => 'tagNames',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Tags'),
            ],
            [
                'attribute' => 'createdByAvatar',
                'format' => 'image',
                'label' => \Yii::t('app', 'Created By'),
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'short'],
                'label' => \Yii::t('app', 'Created At'),
            ],
            [
                'attribute' => 'updatedByAvatar',
                'format' => 'image',
                'label' => \Yii::t('app', 'Updated By'),
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'short'],
                'label' => \Yii::t('app', 'Updated At'),
            ],
        ],
    ])
?>
</div>