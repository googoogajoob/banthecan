<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User*/

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>
<div class="user-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php
        echo $this->render('_form', [ 'model' => $model, ])
    ?>

</div>
