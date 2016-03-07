<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User*/

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];

?>
<div class="user-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('@frontend/views/site/partials/_userIcon', ['userId' => $model->id]); ?>

    <?php
        echo $this->render('partials/_avatar', [ 'model' => $model, ]);
        echo $this->render('partials/_form', [ 'model' => $model, ]);
    ?>

</div>
