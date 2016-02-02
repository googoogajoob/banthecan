<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ActionStep */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="action-step-form"><?php $form = ActiveForm::begin(); ?> <?= $form->field($model, 'created_at')->textInput() ?>

<?= $form->field($model, 'updated_at')->textInput() ?> <?= $form->field($model, 'created_by')->textInput() ?>

<?= $form->field($model, 'updated_by')->textInput() ?> <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?> <?= $form->field($model, 'ticket_id')->textInput() ?>

<?= $form->field($model, 'user_id')->textInput() ?>

<div class="form-group"><?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?></div>
