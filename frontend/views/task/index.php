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

    <?php //echo $this->render('partials/_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Task'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'completed',
                'format' => 'boolean',
                'label' => \Yii::t('app', 'Completed'),
            ],
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
                'format' => 'raw',
                'label' => \Yii::t('app', 'Responsible'),
                'content' => function ($model, $key, $index, $column) {
                    return $this->render('@frontend/views/user/partials/_blame', [
                            'name' => $model->getResponsibleName(),
                            'avatar' => $model->getResponsibleAvatar(),
                        ]
                    );
                },
            ],
            [
                'attribute' => 'ticket.title',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Ticket'),
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Created By'),
                'content' => function ($model, $key, $index, $column) {
                    return $this->render('@frontend/views/user/partials/_blame', [
                            'name' => $model->getCreatedByName(),
                            'avatar' => $model->getCreatedByAvatar(),
                            'timestamp' => $model->created_at,
                        ]
                    );
                },
            ],
            [
                'format' => 'raw',
                'label' => \Yii::t('app', 'Updated By'),
                'content' => function ($model, $key, $index, $column) {
                    return $this->render('@frontend/views/user/partials/_blame', [
                            'name' => $model->getUpdatedByName(),
                            'avatar' => $model->getUpdatedByAvatar(),
                            'timestamp' => $model->updated_at,
                        ]
                    );
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
