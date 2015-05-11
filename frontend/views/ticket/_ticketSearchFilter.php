<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TicketSearch;

/* @var $this yii\web\View */

$searchModel = new TicketSearch();
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
