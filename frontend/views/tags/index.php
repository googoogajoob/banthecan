<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app', 'Tags');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Tags'), 'url' => ['index']];
?>
<div class="tags-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'name',
                    'format' => 'ntext',
                    'label' => \Yii::t('app', 'Name'),
                ],
                [
                    'attribute' => 'frequency',
                    'label' => \Yii::t('app', 'Frequency'),
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    );
?>
</div>
