<?php

use common\models\ticketDecoration\TicketDecorationInterface;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

echo $this->render('@frontend/views/ticket/partials/single/_ticketSingleDecorations', [
        'model' => $model,
    ]
);
?>