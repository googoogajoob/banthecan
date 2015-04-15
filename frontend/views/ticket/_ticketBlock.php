<?php

use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $ticketRecord common\models\Ticket */

$ticketViewUrl = Url::to(['ticket/view', 'id' => $ticket->id]);
?>

    <div class="ticket-avatar">
        <?php echo $this->render('@frontend/views/site/_userIcon', ['userId' => $ticket->created_by]);?>
    </div>

    <strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $ticket->title ?></a></strong><br />

    <div class="clear-both"></div>

    <?php echo Yii::$app->formatter->asDate($ticket->created_at, 'long'); ?>
    <br /><br />
    <?php echo StringHelper::truncate($ticket->description, 100, ' ...'); ?>
