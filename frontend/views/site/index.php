<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $boardActivity array */
/* @var $newTickets array */
/* @var $news array */
/* @var $board ActiveRecord */
?>
<div class="site-index">

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
            <h1 class="text-center bg-info"><?php echo \Yii::t('app', 'Recent Activity'); ?></h1>

            <?php if (count($newTickets)) : ?>
                <div class="col-lg-6">
                    <h2><?php echo \Yii::t('app', 'Tickets'); ?></h2>
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th><?php echo \Yii::t('app', 'Created By'); ?></th>
                                <th><?php echo \Yii::t('app', 'Ticket'); ?></th>
                                <th><?php echo \Yii::t('app', 'Board'); ?></th>
                                <th><?php echo \Yii::t('app', 'Updated By'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($newTickets as $k => $v) {

                                if ($v['column_id'] < 0) {
                                    $boardLink = Html::a(\Yii::t('app', 'Completed'), '/board/completed');
                                } elseif ($v['column_id'] > 0) {
                                    $boardLink = Html::a(\Yii::t('app', 'Board'), '/board');
                                } else {
                                    $boardLink = Html::a(\Yii::t('app', 'Backlog'), '/board/backlog');
                                }

                                echo Html::beginTag('tr')
                                    . Html::tag('td', $v->getCreateUser()->username)
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
                                    . Html::tag('td', $v->getUpdateUser()->username)
                                    . Html::endTag('tr');
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if (count($boardActivity)) : ?>
                <div class="col-lg-6">
                    <h2><?php echo \Yii::t('app', 'Boards'); ?></h2>
                    <table class="table table-condensed table-striped">
                        <thead>
                        <tr>
                            <th><?php echo \Yii::t('app', 'Board'); ?></th>
                            <th><?php echo \Yii::t('app', 'Updates'); ?></th>
                            <th><?php echo \Yii::t('app', 'Size'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($boardActivity as $k => $v) {
                            echo Html::beginTag('tr')
                                . Html::tag('td', Html::a(\Yii::t('app', $k), $v['url']))
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
</div>