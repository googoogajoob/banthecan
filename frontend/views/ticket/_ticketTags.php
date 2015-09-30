<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */

//Ticket Decoration Bar displays the Ticket decorations
echo Html::beginTag('div', ['class' => 'ticket-single-tags']);

echo 'These are Tags';

/*if ($tags = $ticket->tagNames) {
    //Show That Tags exist, singular if only one, plural if more than one
    //This only effects the Glyph-Icon which is shown
    $tagArray = explode(',', $tags);
    $glyphSingularPlural = count($tagArray) > 1 ? 'glyphicon-tags' : 'glyphicon-tag';
    echo "<span
            class=\"glyphicon $glyphSingularPlural ticket-function-bar-glyph\"
            title=\"$tags\"
            data-toggle-click=\"tooltip\"
          ></span>";
}*/

echo Html::endTag('div');
?>