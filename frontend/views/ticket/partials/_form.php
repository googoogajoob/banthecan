<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
/* @var $showAllFields boolean */
?>

<div class="ticket-form"><?php
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

    echo $form->field($model, 'title')->textarea(['rows' => 1]);

    echo $form->field($model, 'description')->textarea(['rows' => 2]);

    if ($showAllFields) {
        //echo $form->field($model, 'vote_priority')->textarea(['rows' => 1]);
        echo $form->field($model, 'protocol')->textarea(['rows' => 2]);
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

    ?>

    <div class="col-sm-offset-2">
        <div class="form-group"><?php
            echo Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
            ?></div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
