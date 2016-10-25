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
                'attribute' => 'tagNames',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Tags'),
            ],
            [
                'attribute' => 'protocol',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Protocol'),
            ],
            [
                'attribute' => 'vote_priority',
                'format' => 'integer',
                'label' => \Yii::t('app', 'Priority'),
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Created By'),
                'content' => function ($model, $key, $index, $column) {
                    return $this->render('@frontend/views/user/partials/_blame', [
                            'name' => $model->getCreatedByName(),
                            'avatar' => $model->getCreatedByAvatar(),
                            'timestamp' => $model->created_at,
                        ]
                    );
                },
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Updated By'),
                'content' => function ($model, $key, $index, $column) {
                    return $this->render('@frontend/views/user/partials/_blame', [
                            'name' => $model->getUpdatedByName(),
                            'avatar' => $model->getUpdatedByAvatar(),
                            'timestamp' => $model->updated_at,
                        ]
                    );
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?></div>
