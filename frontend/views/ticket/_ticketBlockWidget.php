<?php

use yii\helpers\StringHelper;
use yii\jui\Draggable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$ticketViewUrl = Url::to(['ticket/view', 'id' => $ticketRecord['ticketId']]);
$widgetId = 'ticketwidget_'. $ticketRecord['ticketId'];
ob_start;
?>

<?php if (!$sortableWidgetFormat): ?>
    <div id=<?php echo $widgetId; ?> class="ticket-div">
<?php endif; ?>

    <div class="draggable-ticket-avatar-div">
        <img src="/images/content/30x40/user-<?php echo $ticketRecord['assignedId']?>.jpg"/>
    </div>
    <strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $ticketRecord['title']?></a></strong><br />

    <div class="clear-both"></div>

    <?php echo Yii::$app->formatter->asDate($ticketRecord['created'], 'long'); ?>
    <br /><br />
    <?php echo StringHelper::truncate($ticketRecord['description'], 100, ' ...'); ?>

<?php if (!$sortableWidgetFormat): ?>
    </div>
<?php endif; ?>

<?php
    $outputContents = ob_get_contents;
    if ($sortableWidgetFormat) {
        return [
            'content' => $outputContents,
            'options' => [
                'id' => $widgetId,
                'tag' => 'div',
                'class' => 'ticket_widget_div',
            ]

        ];
    } else {
        echo $outputContents;
    }
?>