<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\controllers\TicketController;

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
/* @var $showTag boolean true/false for tag display */
/* @var $showPriority boolean true/false for priority display */

$dependency = [
	'class' => 'yii\caching\DbDependency',
	'sql' => 'SELECT MAX(updated_at) FROM ticket',
];

if ($this->beginCache($model->id, ['dependency' => $dependency])) :

	// the url to view the ticket record (from there it can be edited)
	$ticketViewUrl = Url::to(['ticket/view', 'id' => $model->id]);
?>

	<?php
		// Wrap Contents in a div only when $divClass is set, otherwise contents are returned unwrapped
		if (isset($divClass)) {
			echo Html::beginTag('div', [
                'class' => $divClass,
				'id' => TicketController::TICKET_HTML_PREFIX . $model->id,
			]);
		}
	?>

    <div class="ticket-avatar">
        <?php
            echo $this->render('@frontend/views/site/partials/_userIcon', ['userId' => $model->created_by]);
        ?>
    </div>

    <?php
        if (isset($showPriority) && $showPriority) {
            if ($model->vote_priority > 0) {
                echo Html::beginTag('div', ['class' => 'ticket-vote ticket-vote-plus pull-left']);
                echo '+' . $model->vote_priority;
                echo Html::endTag('div');
            } elseif (($model->vote_priority < 0)) {
                echo Html::beginTag('div', ['class' => 'ticket-vote ticket-vote-minus pull-left']);
                echo $model->vote_priority;
                echo Html::endTag('div');
            } elseif ($model->vote_priority !== null) {
                echo Html::beginTag('div', ['class' => 'ticket-vote ticket-vote-minus pull-left']);
                echo '&plusmn';
                echo Html::endTag('div');
            }
        }
    ?>

	<div class="ticket-single-date">
		<?php
			echo Yii::$app->formatter->asDate($model->created_at, 'short');
		?>
	</div>

    <strong>
		<a href="<?php echo $ticketViewUrl; ?>">
			<?php echo $model->title ?>
		</a>
	</strong>

	<?php
        if ($model->hasDecorations()) {
            echo $this->render('@frontend/views/ticket/partials/_ticketDecorations',
				['ticket' => $model, 'showDiv' => true]);
        }

		if ($showTags) {
			echo $this->render('@frontend/views/ticket/partials/_ticketTags', ['ticket' => $model]);
		}

		// Wrap Contents in a div only when $divClass is set
		if (isset($divClass)) {
			echo Html::endTag('div');
		}

		$this->endCache();
	?>

<?php
	endif; //End of Cache If-Block
?>


