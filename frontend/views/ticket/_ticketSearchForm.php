<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $action string */

?>

<?php $form = ActiveForm::begin([
    'action' => ['board/' . $action],
    'method' => 'get',
]); ?>

<?php
    echo $form->field($searchModel, 'text_search');
    echo $form->field($searchModel, 'from_date')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        //'dateFormat' => 'yyyy-MM-dd',
    ]);
    echo $form->field($searchModel, 'to_date')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        //'dateFormat' => 'yyyy-MM-dd',
    ]);
?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
</div>

<?php ActiveForm::end(); ?>
