<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */

//Ticket Decoration Bar displays the Ticket decorations
echo Html::beginTag('div', ['class' => 'ticket-single-tags']);

if ($taglist = $ticket->tagNames) {
    $tagArray = explode(',', $taglist);
    foreach ($tagArray as $tag) {
        echo '<span class="ticket-tag">' . $tag . '</span>';
    }
}

echo Html::endTag('div');
?>