<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$this->title = \Yii::t('app', 'Update Ticket');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Tickets'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = \Yii::t('app', 'Update');
?>
<div class="ticket-update">

<h1 class="col-sm-offset-2"><?= Html::encode($this->title) ?></h1>

<?php
    echo $this->render('partials/_form', [
        'model' => $model,
        'returnUrl' => isset($returnUrl) ? $returnUrl : null
        ]
    );
?>
</div>
