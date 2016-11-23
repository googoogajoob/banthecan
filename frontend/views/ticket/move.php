<?php

use common\models\ticketDecoration\TicketDecorationLink;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $modalFlag boolean */

?>

<div class="ticket-move">

<h2 class="apc-modal-header"><?php echo \Yii::t('app', 'Movement Options') ?></h2>

<p><?php echo $model->title; ?></p>

<?php if ($model->getColumn()) : ?>

<?php
    $targetColumns = explode(',', $model->getColumn()->receiver);

    foreach ($targetColumns as $columnReceiverId) {
        $columnName = \common\models\Column::findOne($columnReceiverId)->title;

        echo Html::beginForm('/ticket/update/' . $model->id, 'post', ['style' => 'float:left; margin-right: 4px;']);
        echo Html::hiddenInput('Ticket[column_id]', $columnReceiverId);
        echo Html::submitButton($columnName, [
            'class' => 'btn btn-success btn-lg apc-modal-move-btn',
        ]);
        echo Html::endForm();
    }
?>

<?php endif; ?>

<?php
    foreach ($model->getBehaviors() as $ticketDecoration) {

        if ($ticketDecoration instanceof TicketDecorationLink) {

            echo Html::a(
                $ticketDecoration->title,
                $ticketDecoration->getLinkUrl(), [
                'class' => 'btn btn-primary btn-lg apc-modal-move-btn apc-modal-move-btn-decoration',
            ]);

        }
    }
?>

</div>