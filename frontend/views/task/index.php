<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Ticket;
use common\models\Board;
use frontend\assets\TaskAsset;
use apc\markdown\Markdown;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = $this->title;
TaskAsset::register($this);
?>
<p class="task-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php
            echo Html::a(\Yii::t('app', 'Create Task'),
                ['task/create/0'],
                [
                    'class' => 'btn btn-success',
                ]
            );
        ?>
    </p>


<?php Pjax::begin(); ?>

<?php //echo Html::beginForm('/task/complete');?>

    <div id="board-filter" class="pull-right">
        <label class="checkbox-inline">
            <input id="show_backlog" type="hidden" name="boardFilter[show_backlog]"
                <?php echo $searchModel->boardFilter['show_backlog'] ? 'value="1"' : 'value="0"'; ?>
            />
            <input type="checkbox" data-target="show_backlog" onclick="toggleCheckboxValue(this)"
                <?php echo $searchModel->boardFilter['show_backlog'] ? 'checked value="1"' : 'value="0"'; ?>
            />
            <?php echo Board::getBoardSectionName('backlog'); ?>
        </label>

        <label class="checkbox-inline">
            <input id="show_kanban" type="hidden" name="boardFilter[show_kanban]"
                <?php echo $searchModel->boardFilter['show_kanban'] ? 'value="1"' : 'value="0"'; ?>
            />

            <input type="checkbox" data-target="show_kanban" onclick="toggleCheckboxValue(this);"
                <?php echo $searchModel->boardFilter['show_kanban'] ? 'checked value="1"' : 'value="0"'; ?>
            />

            <?php echo Board::getBoardSectionName('kanban'); ?>
        </label>

        <label class="checkbox-inline">
            <input id="show_completed" type="hidden" name="boardFilter[show_completed]"
                <?php echo $searchModel->boardFilter['show_completed'] ? 'value="1"' : 'value="0"'; ?>
            />

            <input type="checkbox" data-target="show_completed" onclick="toggleCheckboxValue(this)"
                <?php echo $searchModel->boardFilter['show_completed'] ? 'checked value="1"' : 'value="0"'; ?>
            />

            <?php echo Board::getBoardSectionName('completed'); ?>
        </label>
    </div>

<?php

    $allBoardUsers = User::getBoardUsers();
    $allBoardUsernames = ArrayHelper::map($allBoardUsers, 'id', 'username');

    $allTaskTickets = Ticket::findTicketsInKanBan()->all();
    $allTaskTicketTitles = ArrayHelper::map($allTaskTickets, 'id', 'title');

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => "#board-filter input[type='hidden']",
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
            /*[
                'class' => 'yii\grid\CheckboxColumn',
                'header' => \Yii::t('app', 'Change Status'),
                'headerOptions' => [
                    'class' => 'text-info'
                ],
                'contentOptions' => [
                    'class' => 'text-center'
                ],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return [
                        'value' => $model->completed ? '-' . $key : $key,
                        'onclick' => 'jQuery(this).closest("form").submit();',
                    ];
                },
            ],*/
            [
                'attribute' => 'title',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Title'),
            ],
            [
                'attribute' => 'description',
                'content' => function ($model, $key, $index, $column) {
                    return Markdown::process($model->description);
                },                'format' => 'raw',
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

                        if ($ticket->column_id > 0) {
                            $ticketSectionName = Board::getBoardSectionName('kanban');;
                        } elseif ($ticket->column_id == 0) {
                            $ticketSectionName = Board::getBoardSectionName('backlog');;
                        } elseif ($ticket->column_id < 0) {
                            $ticketSectionName = Board::getBoardSectionName('completed');;
                        } else {
                            $ticketSectionName = 'Board Section Unknown';
                        }

                        $ticketLink = Html::a(
                                $ticket->title . ' <small>(' . $ticketSectionName . ')</small>',
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
                'class' => '\apc\rewrite\frontend\ActionColumn',
            ],
        ],
    ]);

    //echo Html::endForm();

    ?>

    <?php Pjax::end(); ?>

</div>
