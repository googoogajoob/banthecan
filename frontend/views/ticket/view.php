<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $modalFlag boolean */


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Tickets'), 'url' => ['index']];

$modalClassAddition = $modalFlag ? 'pull-right apc-button-bottom-margin' : '';

$editButton = Html::a(\Yii::t('app', 'Edit'),
    ['/ticket/update', 'id' => $model->id],
    ['class' => 'btn btn-primary ' . $modalClassAddition]);

$deleteButton = Html::a(\Yii::t('app', 'Delete'),
    ['/ticket/delete', 'id' => $model->id],
    ['class' => 'btn btn-danger ' . $modalClassAddition,
     'data' => [
         'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
         'method' => 'post',]]);
?>

<div class="ticket-view">

<h2 class="apc-modal-header"><?= Html::encode($this->title) ?></h2>

<?php if ($modalFlag) : ?>

    <?php echo $deleteButton . $editButton; ?>

<?php endif; ?>

<?php
    $createdBy = $this->render('@frontend/views/user/partials/_blame', [
                    'model' => $model,
                ]
    );

    $updatedBy = $this->render('@frontend/views/user/partials/_blame', [
                    'model' => $model,
                    'useUpdated' => true,
                ]
    );

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
                'visible' => $model->description,
            ],
            [
                'attribute' => 'protocol',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Protocol'),
                'visible' => isset($model->protocol) && $model->protocol,
            ],
            [
                'attribute' => 'vote_priority',
                'format' => 'integer',
                'label' => \Yii::t('app', 'Priority'),
                'visible' => isset($model->vote_priority) && $model->vote_priority,
            ],
            [
                'attribute' => 'tagNames',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Tags'),
                'visible' => isset($model->tagNames) && $model->tagNames,
            ],
            [
                'label' => \Yii::t('app', 'Created'),
                'value' => $createdBy,
                'format'=> 'raw'
            ],
            [
                'label' => \Yii::t('app', 'Updated'),
                'value' => $updatedBy,
                'format'=> 'raw'
            ],
        ],
    ]);
?>

<?php if (!$modalFlag) : ?>
    <p>
        <?php echo $editButton . $deleteButton; ?>
    </p>
<?php endif; ?>

</div>