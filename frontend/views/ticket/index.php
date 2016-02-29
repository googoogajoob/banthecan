<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app', 'Tickets');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('partials/_search', ['model' => $searchModel]); ?>

    <p><?= Html::a(\Yii::t('app', 'Create Ticket'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => \Yii::t('app', 'Begin'),
            'lastPageLabel' => \Yii::t('app', 'End'),
        ],
        'columns' => [
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?></div>
