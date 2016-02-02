<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Resolution */

$this->title = Yii::t('app', 'Create Resolution');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Resolutions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resolution-create">

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
        'model' => $model,
]) ?></div>
