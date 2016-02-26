<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model frontend\models\User*/

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php
        echo $this->render('partials/_form', [ 'model' => $model, ]);
    ?>

</div>
