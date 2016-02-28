<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('partials/_search', ['model' => $searchModel]); ?>

    <p><?= Html::a(\Yii::t('app', 'Create Ticket'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => \Yii::t('app', 'Begin'),
            'lastPageLabel' => \Yii::t('app', 'End'),
        ],
        'columns' => [
            'title:ntext',
            'description:ntext',
            'protocol:ntext',
            'tagNames:ntext:Tags',
            'createdByAvatar:image:',
            'created_at:datetime',
            'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?></div>
