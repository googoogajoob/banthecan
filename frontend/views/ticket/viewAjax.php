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
            'createdByAvatar:image:',
            'description:ntext',
            'protocol:ntext',
            'tagNames:ntext',
            //'createdByName:ntext',
            'created_at:RelativeTime',
],
])
?></div>

<img
	id="ajax-loader" src="/images/ajax-loader.gif" class="hidden" />
