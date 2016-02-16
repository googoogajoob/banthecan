<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ActionStepsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Action Steps');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-step-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Action Step'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            // 'title:ntext',
            // 'description:ntext',
            // 'ticket_id',
            // 'user_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
