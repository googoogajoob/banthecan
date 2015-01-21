<?php

use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$ticketStyle = '
    width: 188px;
    height: 100px;
    background-color: #fff;
    border-style: solid;
    border-color: blue;
    border-width: 1px;
    padding: 5px;
    margin-bottom: 4px;
    float: left;
    ';

$divStyle = '
    background-color: #cdebff;
    width: 180px;
    height: 230px;
    padding: 4px;
    margin: 8px 4px;
    ';
?>

<div style=" <?php echo $divStyle;?> ">
    <strong><?php echo $ticket['title']?></strong><br />
    <?php echo $ticket['assignedName']?><br />
    <?php echo Yii::$app->formatter->asDate($ticket['created'], 'long'); ?>
    <br /><br />
    <?php echo StringHelper::truncate($ticket['description'], 100, ' ...'); ?>
</div>
