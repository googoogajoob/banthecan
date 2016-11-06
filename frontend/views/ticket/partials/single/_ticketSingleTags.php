<?php

use yii\helpers\Html;

//Ticket Decoration Bar displays the Ticket decorations
/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

if ($taglist = $model->tagNames) {

    $tagArray = explode(',', $taglist);
    foreach ($tagArray as $tag) {
        echo Html::tag('div', $tag, ['class' => 'ticket-tag small pull-left']);
    }

}
?>