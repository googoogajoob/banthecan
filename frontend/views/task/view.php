<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use apc\markdown\Markdown;


/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'title',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Title'),
            ],
            [
                'value' => Markdown::process($model->description),
                'format' => 'raw',
                'label' => \Yii::t('app', 'Description'),
            ],
            [
                'attribute' => 'completed',
                'format' => 'boolean',
                'label' => \Yii::t('app', 'Completed'),
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Responsible'),
                'value' => $this->render('@frontend/views/user/partials/_blame', [
                        'model' => $model,
                    ]
                )
            ],
            [
                'attribute' => 'due_date',
                'format' => ['date', 'd.m.Y'],
                'label' => \Yii::t('app', 'Due Date'),
            ],
            [
                'attribute' => 'ticket.title',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Ticket'),
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Created By'),
                'value' => $this->render('@frontend/views/user/partials/_blame', [
                        'model' => $model->getTicket()->one(),
                    ]
                )
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Updated By'),
                'value' => $this->render('@frontend/views/user/partials/_blame', [
                        'model' => $model->getTicket()->one(),
                        'useUpdated' => true,
                    ]
                )
            ],
        ],
    ]) ?>

</div>
