<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$this->title = \Yii::t('app', 'Create Ticket');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Tickets'), 'url' => ['index']];
?>

<div class="ticket-create">

<h1 class="col-sm-offset-2"><?= Html::encode($this->title) ?></h1>

<?php
    echo $this->render('partials/_form', [
        'model' => $model,
        'showAllFields' => false
    ]);
?>
</div>
