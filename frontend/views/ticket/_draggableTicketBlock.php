<?php

use yii\helpers\StringHelper;
use yii\jui\Draggable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

?>

<?php
Draggable::begin([
    'options' => [
        'class' => 'ticket-div',
    ],
    'clientOptions' => [
        //'grid' => [10, 10],
        'cursor' => 'move',
//        'revert' => true,
        'zIndex' => 100,
    ],
]);
$ticketViewUrl = Url::to(['ticket/view', 'id' => $ticketRecord['ticketId']]);
?>

<div class="draggable-ticket-avatar-div">
<img src="/images/content/30x40/user-<?php echo $ticketRecord['assignedId']?>.jpg"/>
</div>
<strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $ticketRecord['title']?></a></strong><br />

<div class="clear-both"></div>

<?php echo Yii::$app->formatter->asDate($ticketRecord['created'], 'long'); ?>
<br /><br />
<?php echo StringHelper::truncate($ticketRecord['description'], 100, ' ...'); ?>

<?php
Draggable::end();
?>
