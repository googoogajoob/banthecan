<?php

use yii\helpers\Html;
use common\models\Board;

/* @var $this yii\web\View */
/* @var $boardActivity array */
/* @var $newTickets array */
/* @var $news array */
/* @var $tasks array */
/* @var $board ActiveRecord */
/* @var $kanBanOverview array */
?>
<div class="site-index">

    <?php if ($board) : ?>

        <div class="kanban-overview">
            <?php foreach ($kanBanOverview as $boardId => $boardData) : ?>
                <div class="kanban-overview-board">
                    <div class="kanban-overview-board-title">
                        <?php echo Html::a($boardData['boardname'], '/board/activate/' . $boardId); ?>
                    </div>
                    <?php foreach ($boardData['tickets'] as $ticketId => $ticketTitle) : ?>
                        <div class="kanban-overview-ticket-title">
                            <?php echo Html::a($ticketTitle, '/ticket/view/' . $ticketId); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="jumbotron">
            <h1>
                <?php echo $board ? Html::encode($board->title) : ''; ?>
            </h1>
            <em class="small">
                <?php echo $board ? Html::encode($board->description) : ''; ?>
            </em>
        </div>

        <div class="body-content">

            <div class="row">

                <?php if (count($newTickets)) : ?>
                    <div class="col-lg-6">
                        <h2><?php echo \Yii::t('app', 'Tickets'); ?></h2>
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><?php echo \Yii::t('app', 'Ticket'); ?></th>
                                    <th><?php echo \Yii::t('app', 'Board'); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($newTickets as $k => $v) {

                                    $createdBy = $this->render('@frontend/views/user/partials/_blame', [
                                            'model' => $v,
                                            'textBelow' => true,
                                            'showName' => false,
                                            'dateFormat' => 'php:d.m'
                                        ]
                                    );

                                    $updatedBy = $this->render('@frontend/views/user/partials/_blame', [
                                            'model' => $v,
                                            'useUpdated' => true,
                                            'alignRight' => true,
                                            'textBelow' => true,
                                            'showName' => false,
                                            'dateFormat' => 'php:d.m'
                                        ]
                                    );

                                    if ($v['column_id'] < 0) {
                                        $boardLink = Html::a(Board::getBoardSectionName('completed'), '/board/completed');
                                    } elseif ($v['column_id'] > 0) {
                                        $boardLink = Html::a(Board::getBoardSectionName('kanban'), '/board');
                                    } else {
                                        $boardLink = Html::a(Board::getBoardSectionName('backlog'), '/board/backlog');
                                    }

                                    echo Html::beginTag('tr')
                                        . Html::tag('td', $createdBy)
                                        . Html::tag('td',
                                            Html::a(
                                                $v->title,
                                                '/ticket/view/' . $v->id,
                                                [
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#global-modal-container',
                                                ]
                                            )
                                        )
                                        . Html::tag('td', $boardLink)
                                        . Html::tag('td', $updatedBy)
                                        . Html::endTag('tr');
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if (count($tasks)) : ?>
                    <div class="col-lg-6">
                        <h2><?php echo \Yii::t('app', 'Tasks'); ?></h2>
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th><?php echo \Yii::t('app', 'Due Date'); ?></th>
                                <th><?php echo \Yii::t('app', 'Title'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($tasks as $k => $v) {
                                echo '<tr><td>'
                                    . Yii::$app->formatter->asDate($v->due_date)
                                    . '</td><td>'
                                    . $v->title
                                    . '</td></tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if (count($boardActivity)) : ?>
                    <div class="col-lg-6">
                        <h2><?php echo \Yii::t('app', 'Board Details'); ?></h2>
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th><?php echo \Yii::t('app', 'Section'); ?></th>
                                <th><?php echo \Yii::t('app', 'Updates'); ?></th>
                                <th><?php echo \Yii::t('app', 'Size'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($boardActivity as $k => $v) {

                                echo Html::beginTag('tr')
                                    . Html::tag('td', Html::a(Board::getBoardSectionName($k), $v['url']))
                                    . Html::tag('td', $v['updates'])
                                    . Html::tag('td', $v['size'])
                                    . Html::endTag('tr');
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if (count($news)) :?>
                    <div class="col-lg-6">
                        <h2><?php echo \Yii::t('app', 'Website'); ?></h2>
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th><?php echo \Yii::t('app', 'Date'); ?></th>
                                <th><?php echo \Yii::t('app', 'Event'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($news as $k => $v) {
                                echo '<tr><td>'
                                    . Yii::$app->formatter->asDate($v->updated_at)
                                    . '</td><td><div title="' . $v->description . '">'
                                    . $v->title
                                    . '</div></td></tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    <?php else : ?>

        <div class="jumbotron">
            <h1>Ban The Can</h1>
            <em class="small">No Board Active</em>
        </div>

    <?php endif; ?>

</div>