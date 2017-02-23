<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\LoginForm */

$this->title = \Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?php echo \Yii::t('app', 'Please fill out the following fields to login:');?></p>

    <div class="row">
        <div class="col-lg-5"><?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?php echo $form->field($model, 'username') ?> <?= $form->field($model, 'password')->passwordInput() ?>
            <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color: #999; margin: 1em 0">
                <?php echo \Yii::t('app', 'If you forgot your password you can');?>
                &nbsp;
                <?php echo Html::a(\Yii::t('app','reset it'), ['site/request-password-reset']) ?>.
            </div>
            <div class="form-group">
                <?php echo Html::submitButton(\Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>