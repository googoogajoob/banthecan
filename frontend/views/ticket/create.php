<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $modalFlag boolean */

$this->title = \Yii::t('app', 'Create Ticket');
$titleClass = $modalFlag ? 'apc-modal-header' : 'col-sm-offset-2';
?>

<div class="ticket-create">

<h2 class="<?php echo $titleClass; ?>"><?= Html::encode($this->title) ?></h2>

<?php
    echo $this->render('partials/_form', [
        'model' => $model,
        'showAllFields' => false,
        'modalFlag' => $modalFlag,
    ]);
?>
</div>
