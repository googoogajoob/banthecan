<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
?>

<div class="ticket-view">

    <img id="ajax-loader" src="/images/ajax-loader.gif" class="hidden"/>

    <h3><?= Html::encode($model->title) ?></h3>

<?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'description:ntext',
            'tagNames:ntext:Tags',
            'createdByName:ntext:Created By',
            'createdByAvatar:image:',
            'created_at:datetime:Created',
            'updated_at:datetime:Updated',
        ],
    ])
?>

</div>
