<?php

use yii\helpers\StringHelper;
use yii\jui\Draggable;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

?>

<?php
Draggable::begin([
    'options' => [
        'class' => 'ticketDivStyle',
    ],
    'clientOptions' => [
        //'grid' => [10, 10],
        'cursor' => 'move',
//        'revert' => true,
        'zIndex' => 100,
    ],
]);
?>

<strong><?php echo $ticketRecord['title']?></strong><br />
<?php echo $ticketRecord['assignedName']?><br />
<?php echo Yii::$app->formatter->asDate($ticketRecord['created'], 'long'); ?>
<br /><br />
<?php echo StringHelper::truncate($ticketRecord['description'], 100, ' ...'); ?>

<?php
Draggable::end();
?>
