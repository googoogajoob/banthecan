<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SiteNews */

$this->title = Yii::t('app', 'Create Site News');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-news-create">

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
        'model' => $model,
]) ?></div>
