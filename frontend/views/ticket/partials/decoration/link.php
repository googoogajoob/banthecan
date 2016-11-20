<?php

use yii\helpers\Html;

/* @var $decoration common\models\ticketDecoration\Link */

echo Html::a(
    $decoration->linkIcon,
    $decoration->showUrl . $decoration->owner->id, [
        'data-toggle' => 'tooltip',
        'data-placement' => 'bottom',
        'title' => \Yii::t('app', $decoration->title),
    ]
);