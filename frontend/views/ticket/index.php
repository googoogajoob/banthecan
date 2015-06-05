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
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ticket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'Begin',
            'lastPageLabel' => 'End',
        ],
        'columns' => [
            'title:ntext',
            'description:ntext',
            'tagNames:ntext:Tags',
            'createdByName:ntext:Created By',
            'createdByAvatar:image:',
            'created_at:datetime:Created',
            'updated_at:datetime:Updated',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
