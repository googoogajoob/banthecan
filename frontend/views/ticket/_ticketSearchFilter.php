<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */

?>

<?php $form = ActiveForm::begin([
    'action' => ['board/backlog'],
    'method' => 'get',
]); ?>

<?php echo $form->field($searchModel, 'title') ?>
<?php echo $form->field($searchModel, 'description') ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
</div>

<?php ActiveForm::end(); ?>
