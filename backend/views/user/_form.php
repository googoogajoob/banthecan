<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;
use common\models\Board;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'username')->textinput(); ?>

    <?php echo $form->field($model, 'email')->textinput(); ?>

    <?php echo $form->field($model, 'status')->radioList(User::$statusText); ?>

    <?php
        $allBoards = Board::find()->orderBy('title')->all();
        $allBoardTitles = ArrayHelper::map($allBoards, 'id', 'title');
    ?>

    <?php echo $form->field($model, 'boardIdArray')->checkboxList($allBoardTitles); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
