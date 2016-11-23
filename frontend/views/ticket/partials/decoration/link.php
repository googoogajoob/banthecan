<?php

use yii\helpers\Html;

/* @var $decoration common\models\ticketDecoration\Link */

echo Html::a(
    $decoration->linkIcon,
    $decoration->getLinkUrl(), [
        'data-toggle' => 'tooltip',
        'data-placement' => 'bottom',
        'title' => \Yii::t('app', $decoration->title),
        'onclick' => 'preventBubbling(event);',
    ]
);