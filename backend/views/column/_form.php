<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\Board;

/* @var $this yii\web\View */
/* @var $model common\models\Column */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="board-column-form">
    <?php
        $form = ActiveForm::begin();

        $allBoards = Board::find()->orderBy('title')->all();
        $allBoardTitles = ArrayHelper::map($allBoards, 'id', 'title');
        echo $form->field($model, 'board_id')->dropDownList($allBoardTitles);

        echo $form->field($model, 'title')->textInput();

        if (!$model->isNewRecord) {
            if ($currentBoard = $model->getBoard()->one()) {
                $boardColumns = $currentBoard->getColumns();
                $boardColumnTitles = ArrayHelper::map($boardColumns, 'id', 'title');
                echo $form->field($model, 'receiverArray')->checkboxList($boardColumnTitles);
            }
        }

        $decorationClasses = Yii::$app->ticketDecorationManager->getAvailableTicketDecorations();
        $decorations = array_combine($decorationClasses, $decorationClasses);
        echo $form->field($model, 'ticket_column_configuration')->checkboxList($decorations);

        echo $form->field($model, 'display_order')->textInput();
    ?>

    <div class="form-group">
        <?php
            echo Html::submitButton(
                $model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'), [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]);
         ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>