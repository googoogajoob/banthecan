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
            'description:ntext',
            'tagNames:ntext:Tags',
            'createdByName:ntext:Created By',
            'createdByAvatar:image:',
            'created_at:RelativeTime:Created',
        ],
    ])
?>

</div>

<img id="ajax-loader" src="/images/ajax-loader.gif" class="hidden"/>
