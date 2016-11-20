<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Board */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="board-form">
    <?php
        $form = ActiveForm::begin();

        //echo $form->field($model, 'id')->textInput();
        //echo $form->field($model, 'created_at')->textInput();
        //echo $form->field($model, 'updated_at')->textInput();
        //echo $form->field($model, 'created_by')->textInput();
        //echo $form->field($model, 'updated_by')->textInput();
        echo $form->field($model, 'title')->textarea(['rows' => 1]);
        echo $form->field($model, 'description')->textarea(['rows' => 2]);
        echo $form->field($model, 'max_lanes')->textInput();
        echo $form->field($model, 'entry_column')->textInput();
        echo $form->field($model, 'backlog_name')->textInput();
        echo $form->field($model, 'kanban_name')->textInput();
        echo $form->field($model, 'completed_name')->textInput();

        $decorationClasses = Yii::$app->ticketDecorationManager->getAvailableTicketDecorations();

        foreach ($decorationClasses as $k => $v) {
            $decorations[$v] = Yii::$app->ticketDecorationManager->getTicketDecorationTitle($v);
        }

        echo $form->field($model, 'ticket_backlog_configuration')->checkboxList($decorations);
        echo $form->field($model, 'ticket_completed_configuration')->checkboxList($decorations);
    ?>

    <div class="form-group">
        <?php
            echo Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
