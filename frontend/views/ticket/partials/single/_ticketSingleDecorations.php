<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $section integer */

$section = isset($section) ? $section : null;

echo Html::beginTag('div', ['class' => 'ticket-single-decorations hidden-xs']);

foreach ($model->getDecorations() as $ticketDecoration) {
    if ($ticketDecoration->displaySection == $section) {
        echo Html::tag('div', $ticketDecoration->render(), [
            'class' => 'ticket-single-decorations-glyph']
        );
    }
}

echo Html::endTag('div');

?>