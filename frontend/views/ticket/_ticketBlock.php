<?php

use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/* I don't like the fact that I need to have parameters for showing the div element
 * However it seems I'm forced to do so.
 *
 * The heart of this view, the content, remains the same
 * but in one context (KanBan board) a div should not be generated,
 * in other contexts (backlog and completed) it is helpful when the div is generated here.
 */

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */
/* @var $divWrapper boolean default true */
/* @var $divClass string  only used when divWrapper is true*/

// the url to view the ticket record (from there it can be edited)
$ticketViewUrl = Url::to(['ticket/view', 'id' => $ticket->id]);

//if the content should be wrapped in a div element
$divWrapper = isset($divWrapper) ? $divWrapper : true;
?>

<?php
    // Wrap Contents in a div only when $divWrapper is true, otherwise only contents are returned
    if ($divWrapper) {
        echo Html::beginTag('div', ['class' => $divClass]);
    }
?>

<div class="ticket-avatar">
    <?php echo $this->render('@frontend/views/site/_userIcon', ['userId' => $ticket->created_by]);?>
</div>

<strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $ticket->title ?></a></strong><br />

<div class="clear-both"></div>

<?php echo Yii::$app->formatter->asDate($ticket->created_at, 'long'); ?>
<br /><br />

<?php
    // Ticket description
    //echo StringHelper::truncate($ticket->description, 100, ' ...'); //Limit using PHP
    //echo $ticket->description; //Limit using CSS overflow
?>

<?php
    //Ticket Info Bar: Tags, toBacklog, toComplete, full display
    if ($tags = $ticket->tagNames) {
        echo Html::beginTag('div', ['class' => 'ticket-function-bar']);

            //Show That Tags exist, singular if only one, plural if more than one
            //This only effects the Glyph-Icon which is shown
            $tagArray = explode(',', $tags);
            $glyphSingularPlural = count($tagArray) > 1 ? 'glyphicon-tags' : 'glyphicon-tag';
            echo "<span
                        class=\"glyphicon $glyphSingularPlural ticket-infobar-glyph\"
                        data-toggle=\"tooltip\"
                        data-placement=\"auto\"
                        data-trigger=\"click\"
                        title=\"$tags\"
                  ></span>";

            $description = $ticket->description;
            echo "<span
                        class=\"glyphicon glyphicon-align-justify ticket-infobar-glyph\"
                        data-toggle=\"tooltip\"
                        data-placement=\"auto\"
                        data-trigger=\"click\"
                        title=\"$description\"
                  ></span>";
        echo Html::endTag('div');
    }
?>

<?php
    // Wrap Contents in a div only when $divWrapper is true, otherwise only contents are returned
    if ($divWrapper) {
        echo Html::endTag('div');
    }
?>


