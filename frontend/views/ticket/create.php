<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$this->title = \Yii::t('app', 'Create Ticket');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Tickets'), 'url' => ['index']];
?>

<div class="ticket-create">

<h2 class="col-sm-offset-2 apc-modal-header"><?= Html::encode($this->title) ?></h2>

<?php
    echo $this->render('partials/_form', [
        'model' => $model,
        'showAllFields' => false
    ]);
?>
</div>
