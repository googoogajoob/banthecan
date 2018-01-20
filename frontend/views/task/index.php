<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Ticket;
use frontend\assets\TaskAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = $this->title;
TaskAsset::register($this);
?>
<div class="task-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php
            echo Html::a(\Yii::t('app', 'Create Task'),
                ['task/create/0'],
                [
                    'class' => 'btn btn-success',
                    'onclick' => 'return setTargetTicket(this);',
                ]
            );
        ?>
    </p>

    <?php Pjax::begin(); ?>

    <?php

    $allBoardUsers = User::getBoardUsers();
    $allBoardUsernames = ArrayHelper::map($allBoardUsers, 'id', 'username');

    $allTaskTickets = Ticket::findTicketsInTaskColumns();
    $allTaskTicketTitles = ArrayHelper::map($allTaskTickets, 'id', 'title');

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $column) {
            if ($model->completed) {
                return ['class' => 'success'];
            } elseif ($model->due_date == 0 || $model->due_date < time()) {
                return ['class' => 'danger'];
            } else {
                return [];
            }
        },
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
                'filter' => $allBoardUsernames,
                'filterInputOptions' => ['class' => 'form-control form-control-task-completed'],
                'attribute' => 'user_id',
            ],
            [
                'attribute' => 'completed',
                'format' => 'boolean',
                'label' => \Yii::t('app', 'Completed'),
                'filter' => [
                    Yii::$app->getFormatter()->asBoolean(0),
                    Yii::$app->getFormatter()->asBoolean(1),
                ],
                'filterInputOptions' => ['class' => 'form-control form-control-task-completed'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y'],
                'label' => \Yii::t('app', 'Created'),
                'filter' => false,
            ],
            [
                'attribute' => 'due_date',
                'format' => ['date', 'php:d.m.Y'],
                'label' => \Yii::t('app', 'Due Date'),
                'filter' => false,
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
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Ticket'),
                'content' => function ($model, $key, $index, $column) {
                    if ($ticket = $model->getTicket()->one()) {

                        $oneClickFilterLink = Html::a(
                            '<span class="glyphicon glyphicon-filter"></span>',
                            '/task?TaskSearch[ticket_id]=' . $ticket->id
                        );

                        $ticketLink = Html::a(
                                $ticket->title,
                                '/ticket/view/' . $ticket->id,
                                [
                                    'data-toggle' => 'modal',
                                    'data-target' => '#global-modal-container',
                                ]
                        );

                        return $oneClickFilterLink . '&nbsp;' . $ticketLink;
                    } else {
                        return '';
                    }
                },
                'filter' => $allTaskTicketTitles,
                'filterInputOptions' => ['class' => 'form-control form-control-task-completed'],
                'attribute' => 'ticket_id',
            ],
            [
                'class' => '\apc\rewrite\frontend\ActionColumn',
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
