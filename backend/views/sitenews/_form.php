<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SiteNews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-news-form"><?php $form = ActiveForm::begin(); ?> <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<div class="form-group"><?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?></div>
