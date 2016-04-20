<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\User*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

	<?php
		$form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'action' => 'upload',
        ]);
		echo $form->field($model, 'imageFile')->fileInput();
	?>

	<div class="form-group">
		<?php
			echo Html::submitButton(Yii::t('app', 'Upload Image'), ['class' => 'btn btn-primary']);
		?>
	</div>

	<?php ActiveForm::end() ?>

</div>
