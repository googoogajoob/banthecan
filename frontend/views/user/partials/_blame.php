<?php

use yii\helpers\Html;
use frontend\models\User;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $avatar string */
/* @var $timestamp integer */

echo Html::img($avatar, ['alt' => $name]);
echo $name . '<br/>';
echo Yii::$app->formatter->asDate($timestamp, 'short');
?>
