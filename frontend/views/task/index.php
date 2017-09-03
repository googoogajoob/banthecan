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

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p><?php echo Html::a(\Yii::t('app', 'Create Task'), ['task/create/0'], ['class' => 'btn btn-success']) ?></p>

    <?php Pjax::begin(); ?>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'format' => 'raw',
                    'label' => \Yii::t('app', 'Responsible'),
                    'content' => function ($model, $key, $index, $column) {
                        return $this->render('@frontend/views/user/partials/_blame', [
                                'model' => $model,
                            ]
                        );
                    },
                ],
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
                    'attribute' => 'ticket.title',
                    'format' => 'ntext',
                    'label' => \Yii::t('app', 'Ticket'),
                ],
                [
                    'format' => 'raw',
                    'label' => \Yii::t('app', 'Created By') . ' / ' . \Yii::t('app', 'Updated By'),
                    'content' => function ($model, $key, $index, $column) {
                        return
                            $this->render('@frontend/views/user/partials/_blame', [
                                'model' => $model,
                            ]
                        ) . $this->render('@frontend/views/user/partials/_blame', [
                                'model' => $model,
                                'useUpdated' => true
                            ]
                        );
                    },
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    ?>

    <?php Pjax::end(); ?>

</div>
