<?php

use common\models\ticketDecoration\TicketDecorationInterface;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $section integer */

$section = isset($section) ? $section : null;

echo Html::beginTag('div', ['class' => 'ticket-single-decorations hidden-xs']);

foreach ($model->getBehaviors() as $ticketBehavior) {

    if ($ticketBehavior instanceof TicketDecorationInterface) {

        if ($ticketBehavior->displaySection == $section) {

            echo Html::tag('div', $ticketBehavior->show(), [
                'class' => 'ticket-single-decorations-glyph']
            );

        }
    }
}

echo Html::endTag('div');

?>