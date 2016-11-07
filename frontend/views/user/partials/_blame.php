<?php

use yii\helpers\Html;
use common\models\Ticket;
use common\models\Task;

/* @var $this yii\web\View */
/* @var $model yii\db\ActiveRecord */
/* @var $useUpdated boolean */
/* @var $alignRight boolean */
/* @var $showName boolean */
/* @var $showDate boolean */
/* @var $textBelow boolean */
/* @var $dateFormat string */

// *****************
// *** Variables ***
// *****************

    $useUpdated = isset($useUpdated) ? $useUpdated : false; // Default use is created
    $alignRight = isset($alignRight) ? $alignRight : false; // Default alignment left
    $showName = isset($showName) ? $showName : true; // Name shown is default, must be explicitly turned off
    $showDate = isset($showDate) ? $showDate : true; // Date shown is default, must be explicitly turned off
    $dateFormat = isset($dateFormat) ? $dateFormat : 'short'; // Date shown as short is default, format can must be explicitly defined
    $textBelow = isset($textBelow) ? $textBelow : false;

    if ($model instanceof Ticket) {
        if ($useUpdated) {

            $userName = $model->getUpdatedByName();
            $avatar = $model->getUpdatedByAvatar();
            $timestamp = $model->updated_at;

        } else {

            $userName = $model->getCreatedByName();
            $avatar = $model->getCreatedByAvatar();
            $timestamp = $model->created_at;

        }
    } elseif ($model instanceof Task) {

        $userName = $model->getResponsibleName();
        $avatar = $model->getResponsibleAvatar();
        $showDate = false;

    } else {
        echo Html::tag('div', 'Unknown Model');

        return;
    }

    if ($alignRight) {

        $avatarOptions = [
            'class' => 'pull-right',
            'style' => 'margin-left: 15px;',
            'title' => $userName,
        ];
        $textOptions = [
            'class' => 'text-right'
        ];

    } else {

        $avatarOptions = [
            'class' => 'pull-left',
            'style' => 'margin-right: 15px;',
        ];
        $textOptions = [
            'class' => 'text-left'
        ];

    }

    $imageOptions['class'] = 'img-responsive';
    $imageOptions['title'] = $userName;
    $imageOptions['data-toggle'] = 'tooltip';

    // ***************
    // *** Display ***
    // ***************

    echo Html::beginTag('div', $textOptions);

    if ($avatar) {
        echo Html::beginTag('div', $avatarOptions);
        echo Html::img($avatar, $imageOptions);
        echo Html::endTag('div');
    }

    if ($textBelow) {
        echo Html::tag('div', '', ['class' => 'clearfix']);
    }

    if ($showName && $userName) {
        echo Html::beginTag('small', $textOptions);
        echo $userName;
        echo Html::endTag('small');
    }

    if ($showName && $showDate) {
        echo Html::tag('br');
    }

    if ($showDate && $timestamp) {
        echo Html::beginTag('small', $textOptions);
        echo Yii::$app->formatter->asDate($timestamp, $dateFormat);
        echo Html::endTag('small');
    }

    echo Html::endTag('div');
?>