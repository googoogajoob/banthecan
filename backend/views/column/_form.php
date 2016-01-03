<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BoardColumn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="board-column-form">

    <?php
        $form = ActiveForm::begin();
        //echo $form->field($model, 'id')->textInput();
        //echo $form->field($model, 'created_at')->textInput();
        //echo $form->field($model, 'updated_at')->textInput();
        //echo $form->field($model, 'created_by')->textInput();
        //echo $form->field($model, 'updated_by')->textInput();
        echo $form->field($model, 'board_id')->textInput();
        echo $form->field($model, 'title')->textarea(['rows' => 1]);
        echo $form->field($model, 'display_order')->textInput();
        echo $form->field($model, 'receiver')->textInput();

        $decorationClasses = Yii::$app->ticketDecorationManager->getAvailableTicketDecorations();
        $decorations = array_combine($decorationClasses, $decorationClasses);

        echo $form->field($model, 'ticket_column_configuration')->checkboxList($decorations);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
