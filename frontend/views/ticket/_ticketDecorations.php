<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */

//Ticket Decoration Bar displays the Ticket decorations
echo Html::beginTag('div', ['class' => 'ticket-single-decorations']);

    $description = $ticket->description;
    echo "<span
            class=\"glyphicon glyphicon-align-justify ticket-single-decorations-glyph\"
            title=\"$description\"
            data-toggle-click=\"tooltip\"
          ></span>";

    if (!$ticket->column_id) {
        //Show Glyph for moving ticket into the KanBanBoard
        echo "<a href=\"\\ticket\\board\\$ticket->id\"><span
                    class=\"glyphicon glyphicon-share-alt ticket-single-decorations-glyph\"
                    title=\"Move to KanBan Board\"
                    data-toggle-hover=\"tooltip\"
                  ></span></a>";
    }

echo Html::endTag('div');
?>