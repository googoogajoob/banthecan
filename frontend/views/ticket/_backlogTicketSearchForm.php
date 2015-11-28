<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use common\models\User;
use frontend\controllers\BoardController;
use dosamigos\selectize\SelectizeTextInput;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $action string */
/* @var $currentPageSize integer */

?>

<?php
    $form = ActiveForm::begin([
        'action' => ['board/' . $action],
        'method' => 'get',
    ]);

    echo Html::hiddenInput('per-page', $currentPageSize , [
        'id' => 'backlog-search-per-page'
    ]);

    echo $form->field($searchModel, 'text_search');

    echo $form->field($searchModel, 'from_date')->widget(DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
    ]);

    echo $form->field($searchModel, 'to_date')->widget(DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
    ]);

    $users = User::getBoardUsers();
    $checkBoxSetup = [];
    foreach ($users as $user) {
        // Include color and grayscale avatar, color when selected, gray when not selected
        // visibility toggled via jQuery/javascript
        $colorId = 'user_search-avatar-color-' . $user->id;
        $grayId  = 'user_search-avatar-gray-'  . $user->id;
        $showColor = is_array($searchModel->user_search) ? in_array($user->id, $searchModel->user_search) : false;
        $checkBoxSetup[$user->id] =
            html::img($user->avatarUrlColor, [
                'alt' => $user->username,
                'title' => $user->username,
                'id' => $colorId,
                'class' => !$showColor ? 'ticket-avatar-hide' : '',
            ])
            . html::img($user->avatarUrlGray, [
                'alt' => $user->username,
                'title' => $user->username,
                'id' => $grayId,
                'class' => $showColor ? 'ticket-avatar-hide' : '',
            ]);
    }

    echo $form->field($searchModel, 'user_search', ['options' => ['class' => 'clearfix']])
        ->checkboxList($checkBoxSetup, ['item' =>
            function ($index, $label, $name, $checked, $value) {
                $inlineJS = '$("#user_search-avatar-color-' . $value . '").toggle();';
                $inlineJS .= '$("#user_search-avatar-gray-' . $value . '").toggle();';
            return  '<div class="checkbox">'
                    . Html::checkbox($name, $checked, [
                    'label' => $label,
                    'value' => $value,
                    'onclick' => $inlineJS,
                    ]) . '</div>';
            }
        ]
    );

    echo $form->field($searchModel, 'tag_search')->widget(SelectizeTextInput::className(), [
        // calls an action that returns a JSON object with matched
        // tags
        'loadUrl' => ['tags/list'],
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'plugins' => ['remove_button'],
            'valueField' => 'name',
            'labelField' => 'name',
            'searchField' => ['name'],
            'create' => true,
        ],
    ])->hint('Use commas to separate tags')

?>

<div class="form-group">
    <?= Html::submitButton('Search', [
        'class' => 'btn btn-primary',
        'id' => 'backlog-search-submit',
    ]) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
</div>

<?php ActiveForm::end(); ?>
