<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = Yii::t('app', 'Update Task');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
?>

<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
