<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use common\models\User;
use dosamigos\selectize\SelectizeTextInput;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $action string */

?>

<?php $form = ActiveForm::begin([
    'action' => ['board/' . $action],
    'method' => 'get',
]); ?>

<?php
    echo $form->field($searchModel, 'text_search');
?>

<div class="collapse" id="searchOptions"> <!-- Collapsible -->

    <?php
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
                    return '<div class="checkbox">'
                        . Html::checkbox($name, $checked, [
                            'label' => $label,
                            'value' => $value,
                            'onclick' => $inlineJS,
                          ])
                        . '</div>';
                    }
                ]
            );

    echo $form->field($searchModel, 'tag_search')->widget(SelectizeTextInput::className(), [
            // calls an action that returns a JSON object with matched
            // tags
            'loadUrl' => ['tag/list'],
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
</div> <!-- Collapsible -->
<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#searchOptions"
            aria-expanded="false" aria-controls="searchExamples">
        More search options ...
    </button>
</div>

<?php ActiveForm::end(); ?>
