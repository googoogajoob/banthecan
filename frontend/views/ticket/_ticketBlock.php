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
/* @var $model common\models\Ticket */
/* @var $divClass string/boolean class name for wrapping DIV or false for no wrapper*/

// the url to view the ticket record (from there it can be edited)
$ticketViewUrl = Url::to(['ticket/view', 'id' => $model->id]);
?>

<?php
    // Wrap Contents in a div only when $divClass is set, otherwise contents are returned unwrapped
    if (isset($divClass)) {
        echo Html::beginTag('div', ['class' => $divClass]);
    }
?>

<div class="ticket-avatar">
    <?php echo $this->render('@frontend/views/site/_userIcon', ['userId' => $model->created_by]);?>
</div>

<strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $model->title ?></a></strong><br />

<div class="clear-both"></div>

<?php echo Yii::$app->formatter->asDate($model->created_at, 'long'); ?>
<br /><br />

<?php
    // Ticket description
    //echo StringHelper::truncate($model->description, 100, ' ...'); //Limit using PHP
    //echo $model->description; //Limit using CSS overflow
?>

<?php
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



    echo Html::endTag('div');
?>

<?php
    // Wrap Contents in a div only when $divClass is set
    if (isset($divClass)) {
        echo Html::endTag('div');
    }
?>


