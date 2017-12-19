<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $section integer */
/* @var $fixedHeightTicketView boolean */

$section = isset($section) ? $section : null;

if ($fixedHeightTicketView) {
    echo Html::beginTag('div', ['class' => 'ticket-single-decorations-float hidden-xs']);
} else {
    echo Html::beginTag('div', ['class' => 'ticket-single-decorations hidden-xs']);
}

foreach ($model->getDecorations() as $ticketDecoration) {
    if ($ticketDecoration->displaySection == $section) {
        echo Html::tag('div', $ticketDecoration->render(), [
            'class' => 'ticket-single-decorations-glyph']
        );
    }
}

echo Html::endTag('div');

?>