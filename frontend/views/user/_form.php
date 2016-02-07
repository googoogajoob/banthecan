<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\models\User*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

<?php
	$form = ActiveForm::begin();
	echo $form->field($model, 'username')->textInput();
	echo $form->field($model, 'email')->textInput();
?>

<div class="form-group">
	<?php
		echo Html::submitButton(
			$model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
			['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
	?>
</div>

<?php ActiveForm::end(); ?>

</div>
