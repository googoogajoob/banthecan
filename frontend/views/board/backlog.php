<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = 'Backlog';

echo $this->render('@frontend/views/board/_backlogAndCompleted', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
