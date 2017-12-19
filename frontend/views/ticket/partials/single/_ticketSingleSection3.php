<?php


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $fixedHeightTicketView boolean */


if ($model->hasDecorations()) {
    echo $this->render('@frontend/views/ticket/partials/single/_ticketSingleDecorations', [
            'model' => $model,
            'fixedHeightTicketView' => $fixedHeightTicketView,
        ]
    );
}

$moveParameter = '/ticket/move/' . $model->id;
echo Html::a('Move', '/#', [
    'class' => 'btn apc-btn-move hidden-sm hidden-md hidden-lg',
    'style' => 'width: 100%;',
    'onclick' => "return ticketMove('" . $moveParameter . "', event);",
]);

?>