<?php

use common\models\ticketDecoration\TicketDecorationInterface;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $modalFlag boolean */

?>

<div class="ticket-move">

<h2 class="apc-modal-header"><?php echo \Yii::t('app', 'Movement Options') ?></h2>

<p><?php echo $model->title; ?></p>

<h4>Decoration Movement Options</h4>

<?php
    foreach ($model->getBehaviors() as $ticketBehavior) {

        if ($ticketBehavior instanceof TicketDecorationInterface) {

            if (!$ticketBehavior->displaySection && $ticketBehavior->movement) {

                echo Html::tag('div', $ticketBehavior->show(), [
                'class' => 'ticket-single-decorations-glyph']
                );

            }
        }
    }
?>

<?php if ($model->getColumn()) : ?>

<h4>Column Movement Options</h4>

<?php
    $targetColumns = explode(',', $model->getColumn()->receiver);

    foreach ($targetColumns as $columnReceiverId) {
        $columnName = \common\models\Column::findOne($columnReceiverId)->title;

        echo Html::beginForm('/ticket/update/' . $model->id, 'post', ['style' => 'float:left; margin-right: 4px;']);
        echo Html::hiddenInput('Ticket[column_id]', $columnReceiverId);
        echo Html::submitButton($columnName);
        echo Html::endForm();
    }
?>

<?php endif; ?>

</div>