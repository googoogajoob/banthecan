<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
/* @var $showAllFields boolean */
/* @var $modalFlag boolean */

$buttonClass = $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary';
$buttonLabel = $model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update');
?>

<div class="ticket-form">
    <?php
    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-2',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);
    ?>

    <?php if ($modalFlag) : ?>
    <div class="col-sm-offset-1">
        <div class="form-group">
            <?php
                $buttonClass .= ' pull-right';
                echo Html::submitButton(
                    $buttonLabel,
                    ['class' => $buttonClass]
                );
            ?>
        </div>
    </div>
    <?php endif; ?>

    <?php
    echo $form->field($model, 'title')->textarea(['rows' => 1]);

    echo $form->field($model, 'description')->textarea(['rows' => 5]);

    if ($showAllFields) {
        echo $form->field($model, 'protocol')->textarea(['rows' => 5]);
    }

    echo $form->field($model, 'tagNames')->widget(SelectizeTextInput::className(), [
        // calls an action that returns a JSON object with matched tags
        'loadUrl' => ['tags/list'],
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'plugins' => ['remove_button'],
            'valueField' => 'name',
            'labelField' => 'name',
            'searchField' => ['name'],
            'create' => true,
        ],
    ])->hint(\Yii::t('app', 'Use commas to separate tags'));

    echo Html::hiddenInput('modalFlag', $modalFlag ? 1 : 0);

    ?>

    <?php if (!$modalFlag) : ?>
    <div class="col-sm-offset-1">
        <div class="form-group">
            <?php
                echo Html::submitButton(
                    $buttonLabel,
                    ['class' => $buttonClass]
                );
            ?>
        </div>
    </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>
</div>
