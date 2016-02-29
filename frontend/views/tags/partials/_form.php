<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tags-form">
    <?php
        $form = ActiveForm::begin();
        echo $form->field($model, 'name')->textarea(['rows' => 1]);
    ?>

    <div class="form-group">
        <?php
            echo Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app',
                'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        ?>
    </div>

    <?php
        ActiveForm::end();
    ?>
</div>
