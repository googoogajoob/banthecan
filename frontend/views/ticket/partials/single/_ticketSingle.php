<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\controllers\TicketController;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $showKanBanAvatar boolean */
/* @var $fixedHeightTicketView boolean */

$dependency = [
    'class' => 'yii\caching\DbDependency',
    'sql' => 'SELECT MAX(updated_at) FROM ticket',
];

$fixedHeightTicketView = isset($fixedHeightTicketView) ? $fixedHeightTicketView : true;

if ($fixedHeightTicketView) {
    $sectionOneClass = "ticket-widget-section-one-float clearfix";
    $sectionTwoClass = "ticket-widget-section-two-float clearfix";
    $sectionThreeClass = "ticket-widget-section-three-float clearfix";
} else {
    $sectionOneClass = "ticket-widget-section-one clearfix";
    $sectionTwoClass = "ticket-widget-section-two clearfix";
    $sectionThreeClass = "ticket-widget-section-three clearfix";
}

if ($this->beginCache($model->id, ['dependency' => $dependency])) : //Begin of Cache If-Block

    $ticketViewUrl = Url::to(['ticket/view', 'id' => $model->id]);
    $isKanBan = $model->column_id > 0;

    // Container DIV is different depending on which board one is on
    // KanBan is sortable (created in the parent view), Backlog/Completed float
    if (!$isKanBan) {
        $moveParameter = '/ticket/view/' . $model->id;
        echo Html::beginTag('div', [
            'class' => 'ticket-widget-float',
            'id' => TicketController::TICKET_HTML_PREFIX . $model->id,
            'onclick' => "return ticketMove('" . $moveParameter . "', event);",
        ]);
    }
?>

<div class="<?php echo $sectionOneClass; ?>">
    <?php
        echo $this->render('@frontend/views/ticket/partials/single/_ticketSingleSection1', [
            'model' => $model,
            'showVote' => $isKanBan,
            'showKanBanAvatar' => isset($showKanBanAvatar) ? $showKanBanAvatar : true,
            ]
        );
    ?>
</div>

<?php if ($fixedHeightTicketView) : ?>
<div class="<?php echo $sectionTwoClass; ?>">
    <?php
        echo $this->render('@frontend/views/ticket/partials/single/_ticketSingleSection2', [
            'model' => $model,
            'isKanBan' => $isKanBan,
            ]
        );
    ?>
</div>
<?php endif; ?>

<div class="<?php echo $sectionThreeClass; ?>">
    <?php
        echo $this->render('@frontend/views/ticket/partials/single/_ticketSingleSection3', [
            'model' => $model,
            'fixedHeightTicketView' => $fixedHeightTicketView,
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