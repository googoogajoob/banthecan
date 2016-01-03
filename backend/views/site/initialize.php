<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Initialize';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <a href="/site/initialize"><?php echo \Yii::t('app', 'INITIALIZE USER DB'); ?></a>
    </p>
</div>
