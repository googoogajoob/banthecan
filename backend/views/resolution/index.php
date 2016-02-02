<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Resolutions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resolution-index">

<h1><?= Html::encode($this->title) ?></h1>

<p><?= Html::a(Yii::t('app', 'Create Resolution'), ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'title:ntext',
            'description:ntext',
            'ticket_id',

['class' => 'yii\grid\ActionColumn'],
],
]); ?></div>
