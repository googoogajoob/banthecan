<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Resolution */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Resolutions'), 'url' => ['index']];
?>
<div class="resolution-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
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
                'attribute' => 'ticket.title',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Ticket'),
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Created By'),
                'value' => $this->render('@frontend/views/user/partials/_blame', [
                        'name' => $model->getCreatedByName(),
                        'avatar' => $model->getCreatedByAvatar(),
                        'timestamp' => $model->created_at,
                    ]
                )
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Updated By'),
                'value' => $this->render('@frontend/views/user/partials/_blame', [
                        'name' => $model->getUpdatedByName(),
                        'avatar' => $model->getUpdatedByAvatar(),
                        'timestamp' => $model->updated_at,
                    ]
                )
            ],
        ],
    ]) ?>

</div>
