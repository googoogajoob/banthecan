<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Task'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Title'),
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Description'),
            ],
            [
                'attribute' => 'responsibleAvatar',
                'format' => 'image',
                'label' => \Yii::t('app', 'Responsible'),
            ],
            [
                'attribute' => 'completed',
                'format' => 'boolean',
                'label' => \Yii::t('app', 'Completed'),
            ],
            [
                'attribute' => 'ticket.title',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Ticket Title'),
            ],
            [
                'attribute' => 'createdByAvatar',
                'format' => 'image',
                'label' => \Yii::t('app', 'Created By'),
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'short'],
                'label' => \Yii::t('app', 'Created At'),
            ],
            [
                'attribute' => 'updatedByAvatar',
                'format' => 'image',
                'label' => \Yii::t('app', 'Updated By'),
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'short'],
                'label' => \Yii::t('app', 'Updated At'),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
