<?php

use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */
/* @var $divClass string */

$ticketViewUrl = Url::to(['ticket/view', 'id' => $ticket->id]);
$sortableID = 'ticketwidget_'. $ticket->id;
?>

<div id="<?php echo $sortableID; ?>" class="<?php echo $divClass; ?>">
    <div class="ticket-avatar">
        <?php echo $this->render('@frontend/views/site/_userIcon', ['userId' => $ticket->created_by]);?>
    </div>

    <strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $ticket->title ?></a></strong><br />

    <div class="clear-both"></div>

    <?php echo Yii::$app->formatter->asDate($ticket->created_at, 'long'); ?>
    <br /><br />
    <?php echo StringHelper::truncate($ticket->description, 100, ' ...'); ?>
</div>