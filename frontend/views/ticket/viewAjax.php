<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
?>

<div class="ticket-view">

<h3><?= Html::encode($model->title) ?></h3>

<?php
echo DetailView::widget([
        'model' => $model,
        'options' => [
            'tag' => 'ul',
            'class' => 'ticket-view-ajax clearfix',
        ],
        'template' => '<li><span class="label">{label}</span><span class="data">{value}</span></li>',
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
                'attribute' => 'vote_priority',
                'format' => 'integer',
                'label' => \Yii::t('app', 'Priority'),
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
    ]
);
?>
</div>

<img
	id="ajax-loader" src="/images/ajax-loader.gif" class="hidden" />
