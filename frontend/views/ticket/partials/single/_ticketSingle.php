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

if ($this->beginCache($model->id, ['dependency' => $dependency])) : //Begin of Cache If-Block

    $ticketViewUrl = Url::to(['ticket/view', 'id' => $model->id]);
    $isKanBan = $model->column_id > 0;

    // Container DIV is different depending on which board one is on
    // KanBan is sortable (created in the parent view), Backlog/Completed float
    if (!$isKanBan) {
        echo Html::beginTag('div', [
            'class' => 'ticket-widget-float',
            'id' => TicketController::TICKET_HTML_PREFIX . $model->id,
            'onclick' => 'ticketClick(' . $model->id . '); return false;',
        ]);
    }
?>

<div class="ticket-widget-section-one">
    <?php
        echo $this->render('@frontend/views/ticket/partials/single/_ticketSingleSection1', [
            'model' => $model,
            'showVote' => $isKanBan,
            ]
        );
    ?>
</div>

<div class="ticket-widget-section-two">
    <?php
        echo $this->render('@frontend/views/ticket/partials/single/_ticketSingleSection2', [
            'model' => $model,
            'isKanBan' => $isKanBan,
            ]
        );
    ?>
</div>

<div class="ticket-widget-section-three">
    <?php
        echo $this->render('@frontend/views/ticket/partials/single/_ticketSingleSection3', [
            'model' => $model,
            ]
        );
    ?>
</div>

<?php
    if (!$isKanBan) {
        echo Html::endTag('div');
    }

    $this->endCache();

endif; //End of Cache If-Block

?>