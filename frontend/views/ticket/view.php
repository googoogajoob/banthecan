<?php

use yii\helpers\Html;
use yii\helpers\Markdown;
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

    <?php
        echo Html::a(
            '<span class="glyphicon glyphicon-text-size"></span>',
            '#',
            [
                'class' => 'btn pull-left' . $modalClassAddition,
                'title' => \Yii::t('app', 'Textsize larger/smaller'),
                'onclick' => "toggleModalFontsize();",
            ]
        );
    ?>

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
                'value' => Markdown::process($model->description),
                'format' => 'raw',
                'label' => \Yii::t('app', 'Description'),
                'visible' => $model->description,
            ],
            [
                'value' => Markdown::process($model->protocol),
                'format' => 'raw',
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
                'label' => \Yii::t('app', 'Created') . ' / ' . \Yii::t('app', 'Updated'),
                'value' => $createdBy . $updatedBy,
                'format'=> 'raw'
            ],
        ],
    ]);

    echo Html::tag('em', $model->id, ['class' => 'pull-right text-muted small']);
?>

<?php if (!$modalFlag) : ?>
    <p>
        <?php echo $editButton . $deleteButton; ?>
    </p>
<?php endif; ?>

</div>