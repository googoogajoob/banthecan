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
    ]);
?>

<?php if (!$modalFlag) : ?>
    <p>
        <?php echo $editButton . $deleteButton; ?>
    </p>
<?php endif; ?>

</div>