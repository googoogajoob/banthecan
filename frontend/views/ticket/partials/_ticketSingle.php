<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\controllers\TicketController;

/* I don't like the fact that I need to have parameters for showing the div element
 * However it seems I'm forced to do so.
 *
 * The heart of this view, the content, remains the same
 * but in one context (KanBan board) a div should not be generated,
 * in other contexts (backlog and completed) it is helpful when the div is generated here.
 */

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $divClass string/boolean class name for wrapping DIV or false for no wrapper*/
/* @var $showTagMax int/boolean maximum number of tags to show, false for no tag display */

// the url to view the ticket record (from there it can be edited)
$ticketViewUrl = Url::to(['ticket/view', 'id' => $model->id]);
?>

<?php
    // Wrap Contents in a div only when $divClass is set, otherwise contents are returned unwrapped
    if (isset($divClass)) {
        echo Html::beginTag('div', [
            'class' => $divClass,
            'id' => TicketController::TICKET_HTML_PREFIX . $model->id,
        ]);
    }
?>

<div class="ticket-avatar">
    <?php echo $this->render('@frontend/views/site/partials/_userIcon', ['userId' => $model->created_by]);?>
</div>

<?php echo Yii::$app->formatter->asDate($model->created_at, 'long'); ?>

<div class="clear-both"></div>

<strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $model->title ?></a></strong><br />

<br /><br />

<?php
    echo Html::beginTag('div', ['class' => 'ticket-single-decorations']);
    echo $this->render('@frontend/views/ticket/partials/_ticketDecorations', ['ticket' => $model]);
    echo Html::endTag('div');

    if ($showTagMax) {
        echo $this->render('@frontend/views/ticket/partials/_ticketTags', ['ticket' => $model, 'showTagMax' => $showTagMax]);
    }

    // Wrap Contents in a div only when $divClass is set
    if (isset($divClass)) {
        echo Html::endTag('div');
    }
?>


