<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */
/* @var $showTagMax int/boolean maximum number of tags to display*/

//Ticket Decoration Bar displays the Ticket decorations
echo Html::beginTag('div', ['class' => 'ticket-single-tags']);

if ($taglist = $ticket->tagNames) {
    $tagArray = explode(',', $taglist);
    $tagCounter = 0;
    foreach ($tagArray as $tag) {
        $tagCounter++;
        if ($tagCounter > $showTagMax) {
            break;
        }
        echo '<span class="ticket-tag text-overflow">' . $tag . '</span>';
    }
}

echo Html::endTag('div');
?>