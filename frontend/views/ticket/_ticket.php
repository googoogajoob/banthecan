<?php

use yii\helpers\StringHelper;
use yii\jui\Draggable;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

?>

<?php
Draggable::begin([
  'clientOptions' => ['grid' => [188,100]],
]);
?>

<div class="ticketDivStyle">
    <strong><?php echo $ticket['title']?></strong><br />
    <?php echo $ticket['assignedName']?><br />
    <?php echo Yii::$app->formatter->asDate($ticket['created'], 'long'); ?>
    <br /><br />
    <?php echo StringHelper::truncate($ticket['description'], 100, ' ...'); ?>
</div>

<?php
Draggable::end();
?>
