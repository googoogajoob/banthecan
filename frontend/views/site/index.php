<?php

use yii\helpers\Html;
use common\models\Board;

/* @var $this yii\web\View */
/* @var $boardActivity array */
/* @var $newTickets array */
/* @var $news array */
/* @var $board ActiveRecord */
?>
<div class="site-index">

    <?php if ($board) : ?>

        <div class="jumbotron">
            <h1>
                <?php echo $board ? Html::encode($board->title) : ''; ?>
            </h1>
            <em class="small">
                <?php echo $board ? Html::encode($board->description) : ''; ?>
            </em>
        </div>

        <div class="body-content">

            <h1 class="text-center bg-info"><?php echo \Yii::t('app', 'Recent Activity'); ?></h1>

            <div class="row">

                <?php if (count($newTickets)) : ?>
                    <div class="col-lg-12">
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
                                    . Yii::$app->formatter->asDate($v->updated_at, 'long')
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