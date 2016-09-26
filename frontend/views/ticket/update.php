<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$modalFlag = isset($modalFlag);
$this->title = \Yii::t('app', 'Update Ticket');
$titleClass = $modalFlag ? 'apc-modal-header' : 'col-sm-offset-2';
?>

<div class="ticket-update">

<h2 class="<?php echo $titleClass; ?>"><?= Html::encode($this->title) ?></h2>

<?php
    echo $this->render('partials/_form', [
        'model' => $model,
        'showAllFields' => true,
        'modalFlag' => $modalFlag,
    ]);
?>
</div>
