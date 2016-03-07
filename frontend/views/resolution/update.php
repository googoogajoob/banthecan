<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Resolution */

$this->title = Yii::t('app', 'Update Resolution');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Resolutions'), 'url' => ['index']];

?>

<div class="resolution-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
