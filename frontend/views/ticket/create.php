<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $returnUrl common\models\Ticket */

$this->title = 'Create Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">

    <h1 class="col-sm-offset-2"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'returnUrl' => isset($returnUrl) ? $returnUrl : null
    ]) ?>

</div>
