<?php

use yii\helpers\Html;

/* I don't like the fact that I need to have parameters for showing the div element
 * However it seems I'm forced to do so.
 *
 * The heart of this view, the content, remains the same
 * but in one context (KanBan board) a div should not be generated,
 * in other contexts (backlog and completed) it is helpful when the div is generated here.
 */

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

//Ticket Info Bar: Tags, toBacklog, toComplete, full display
echo Html::beginTag('div', ['class' => 'ticket-function-bar']);

    if ($tags = $model->tagNames) {
        //Show That Tags exist, singular if only one, plural if more than one
        //This only effects the Glyph-Icon which is shown
        $tagArray = explode(',', $tags);
        $glyphSingularPlural = count($tagArray) > 1 ? 'glyphicon-tags' : 'glyphicon-tag';
        echo "<span
                class=\"glyphicon $glyphSingularPlural ticket-function-bar-glyph\"
                title=\"$tags\"
                data-toggle=\"tooltip\"
                data-placement=\"auto\"
                data-trigger=\"hover\"
              ></span>";
    }

    $description = $model->description;
    echo "<span
            class=\"glyphicon glyphicon-align-justify ticket-function-bar-glyph\"
            title=\"$description\"
            data-toggle=\"tooltip\"
            data-placement=\"auto\"
            data-trigger=\"hover\"
          ></span>";

    if (!$model->column_id) {
        //Show Glyph for moving ticket into the KanBanBoard
        echo "<span
                    class=\"glyphicon glyphicon-share-alt ticket-function-bar-glyph\"
                    title=\"Move to KanBan Board\"
                    data-toggle=\"tooltip\"
                    data-placement=\"auto\"
                    data-trigger=\"hover\"
                  ></span>";
    }

echo Html::endTag('div');
?>