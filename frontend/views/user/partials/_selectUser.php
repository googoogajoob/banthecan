<?php

/**
 * Creates an active Form Field for selecting one user and delivers the user->id
 */

use yii\helpers\Html;
use frontend\models\User;
use frontend\assets\TaskAsset;


/* @var $this yii\web\View */
/* @var $model frontend\models\User*/
/* @var $form yii\widgets\ActiveForm */

TaskAsset::register($this);
?>

<?php
$users = User::getBoardUsers();
$checkBoxSetup = [];
foreach ($users as $user) {
    // Include color and grayscale avatar, color when selected, gray when not selected
    // visibility toggled via jQuery/javascript
    $colorId = 'user_id-avatar-color-' . $user->id;
    $grayId = 'user_id-avatar-gray-' . $user->id;
    $checkBoxSetup[$user->id] =
        html::img($user->avatarUrlColor, [
            'alt' => $user->username,
            'title' => $user->username,
            'id' => $colorId,
            'class' => 'user-avatar-hide',
        ])
        . html::img($user->avatarUrlGray, [
            'alt' => $user->username,
            'title' => $user->username,
            'id' => $grayId,
        ]);
}

echo $form->field($model, 'user_id', ['options' => ['class' => 'clearfix']])
    ->radioList($checkBoxSetup, [
            'item' =>
                function ($index, $label, $name, $checked, $value) {
                    $inlineJS = '$("#user_id-avatar-color-' . $value . '").toggle();';
                    $inlineJS .= '$("#user_id-avatar-gray-' . $value . '").toggle();';
                    return '<div class="radio">'
                    . Html::radio($name, $checked, [
                        'label' => $label,
                        'value' => $value,
                        'onchange' => $inlineJS,
                    ]) . '</div>';
                }
        ]
    );
?>