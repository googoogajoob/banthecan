<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\controllers\TicketController;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$dependency = [
    'class' => 'yii\caching\DbDependency',
    'sql' => 'SELECT MAX(updated_at) FROM ticket',
];

if ($this->beginCache($model->id, ['dependency' => $dependency])) :

    // the url to view the ticket record (from there it can be edited)
    $ticketViewUrl = Url::to(['ticket/view', 'id' => $model->id]);

    $isKanBan = $model->column_id != 0;

    if (!$isKanBan) {
        // Container DIV is different depending on which board one is on
        // KanBan is sortable (created in the parent view), Backlog/Completed float
        echo Html::beginTag('div', [
            'class' => 'ticket-widget-float',
            'id' => TicketController::TICKET_HTML_PREFIX . $model->id,
        ]);
    }
?>

<div class="ticket-widget-section-one">

    <div class="pull-right">
        <?php
            echo $this->render('@frontend/views/user/partials/_blame', [
                'model' => $model,
                'useUpdated' => true,
                'alignRight' => true,
                'textBelow' => true,
                'showName' => false,
                'dateFormat' => 'php:d.m'
                ]
            );
        ?>
    </div>

    <?php
        if (!$isKanBan) {
            $voteClass = 'ticket-vote pull-left';

            if ($model->vote_priority > 0) {
                $voteClass .= ' ticket-vote-plus';
                $voteText = '+' . $model->vote_priority;
            } elseif ($model->vote_priority < 0) {
                $voteClass .= ' ticket-vote-minus';
                $voteText = $model->vote_priority;
            } elseif ($model->vote_priority !== null) {
                $voteClass .= ' ticket-vote-minus';
                $voteText = '&plusmn';
            }

            if (isset($voteText)) {
                echo Html::tag('div', $voteText, ['class' => $voteClass]);
            }
        }

        echo $model->title;
    ?>

</div>

<div class="ticket-widget-section-two">
    <?php
        if ($isKanBan) {
            echo "Tasks - Resolutions - Protocol";
        } else {
            echo $this->render('@frontend/views/ticket/partials/_ticketTags', ['ticket' => $model]);
        }
    ?>
</div>

<div class="ticket-widget-section-three">
    <?php
        if ($model->hasDecorations()) {
            echo $this->render('@frontend/views/ticket/partials/_ticketDecorations',
                ['ticket' => $model, 'showDiv' => true]);
        }
    ?>
</div>

<?php
    if (!$isKanBan) {
        echo Html::endTag('div');
    }

    $this->endCache();

	endif; //End of Cache If-Block
?>