<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $action string */

?>

<?php $form = ActiveForm::begin([
    'action' => ['board/' . $action],
    'method' => 'get',
]); ?>

<?php echo $form->field($searchModel, 'text_search') ?>
<?php echo $form->field($searchModel, 'from_date') ?>
<?php echo $form->field($searchModel, 'to_date') ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
</div>

<?php ActiveForm::end(); ?>
