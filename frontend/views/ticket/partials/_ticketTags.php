<?php

use yii\helpers\Html;

//Ticket Decoration Bar displays the Ticket decorations
/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */

if ($taglist = $ticket->tagNames) {

    $tagArray = explode(',', $taglist);
    foreach ($tagArray as $tag) {
        echo Html::tag('div', $tag, ['class' => 'ticket-tag small pull-left']);
    }

}
?>