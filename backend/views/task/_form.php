<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Board;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php
        $form = ActiveForm::begin();
        echo $form->field($model, 'title')->textarea(['rows' => 1]);
        echo $form->field($model, 'description')->textarea(['rows' => 2]);

        $boards = Board::find()->all();
        $boardItems = ArrayHelper::map($boards, 'id', 'title');
        echo $form->field($model, 'board_id')->dropDownList($boardItems);

        echo $form->field($model, 'created_at')->textInput();
        echo $form->field($model, 'updated_at')->textInput();
        echo $form->field($model, 'created_by')->textInput();
        echo $form->field($model, 'updated_by')->textInput();
        echo $form->field($model, 'ticket_id')->textInput();
        echo $form->field($model, 'user_id')->textInput();
        echo $form->field($model, 'completed')->textInput();
        echo $form->field($model, 'due_date')->textInput();
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
