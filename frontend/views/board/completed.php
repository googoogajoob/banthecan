<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $action string */

?>

<h1 class="text-capitalize">
    <?php echo Html::encode($action) ?>
</h1>

<?php
echo $this->render('@frontend/views/board/_backlogAndCompleted', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'action' => $action,
    ]);
