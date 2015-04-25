<?php

use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/* I don't like the fact that I need to have parameters for showing the div element
 * However it seems I'm forced to do so.
 *
 * The heart of this view the content remains the same
 * but in one context (KanBan board) a div should not be generated,
 * in other contexts (backlog and completed) it is helpful when the div is generated here.
 */

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */
/* @var $divWrapper boolean default true */
/* @var $divClass string  only used when divWrapper is true*/

// the url to view/edit the ticket record
$ticketViewUrl = Url::to(['ticket/view', 'id' => $ticket->id]);
//if the content should be wrapped in a div element
$divWrapper = isset($divWrapper) ? $divWrapper : true;
?>

<?php
    // Wrap Contents in a div only when $divWrapper is true, otherwise only contents are returned
    if ($divWrapper) {
        echo Html::beginTag('div', ['class' => $divClass]);
    }
?>

    <div class="ticket-avatar">
        <?php echo $this->render('@frontend/views/site/_userIcon', ['userId' => $ticket->created_by]);?>
    </div>

    <strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $ticket->title ?></a></strong><br />

    <div class="clear-both"></div>

    <?php echo Yii::$app->formatter->asDate($ticket->created_at, 'long'); ?>
    <br /><br />
    <?php
        //echo StringHelper::truncate($ticket->description, 100, ' ...');
        echo $ticket->description;
    ?>

<?php
    // Wrap Contents in a div only when $divWrapper is true, otherwise only contents are returned
    if ($divWrapper) {
        echo Html::endTag('div');
    }
?>