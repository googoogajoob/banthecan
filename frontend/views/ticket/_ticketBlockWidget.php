<?php

use yii\helpers\StringHelper;
use yii\jui\Draggable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$ticketViewUrl = Url::to(['ticket/view', 'id' => $ticketRecord['ticketId']]);
ob_start;
?>

<?php if (!$sortable): ?>
    <div id="ticketwidget_"<?php echo $ticketRecord['ticketId']?> class="ticket-div ui-draggable ui-draggable-handle">
<?php endif; ?>

    <div class="draggable-ticket-avatar-div">
        <img src="/images/content/30x40/user-<?php echo $ticketRecord['assignedId']?>.jpg"/>
    </div>
    <strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $ticketRecord['title']?></a></strong><br />

    <div class="clear-both"></div>

    <?php echo Yii::$app->formatter->asDate($ticketRecord['created'], 'long'); ?>
    <br /><br />
    <?php echo StringHelper::truncate($ticketRecord['description'], 100, ' ...'); ?>

<?php if (!$sortable): ?>
    </div>
<?php endif; ?>

<?php
    $outputContents = ob_get_contents;
    if ($sortable) {
        return [
            'item' => $outputContents,

        ];
    } else {
        echo $outputContents;
    }
?>