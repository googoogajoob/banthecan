<?php

use yii\helpers\Html;

//Ticket Decoration Bar displays the Ticket decorations
/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $isKanBan boolean */
?>

<?php
    if ($isKanBan) {
        echo $this->render('@frontend/views/ticket/partials/_ticketRelatedInfo', ['ticket' => $model]);
    } else {
        echo $this->render('@frontend/views/ticket/partials/_ticketTags', ['ticket' => $model]);
    }
?>
