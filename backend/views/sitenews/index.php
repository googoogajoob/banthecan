<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Site News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-news-index">

<h1><?php echo Html::encode($this->title) ?></h1>

<p>
    <?php echo Html::a(Yii::t('app', 'Create Site News'), ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'boardTitle',
            'title:ntext',
            'description:ntext',
            'created_at:date',
            'updated_at:date',
            'created_by',
            'updated_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
?>
</div>
