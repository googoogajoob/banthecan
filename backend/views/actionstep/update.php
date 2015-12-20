<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ActionStep */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Action Step',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Action Steps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="action-step-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
