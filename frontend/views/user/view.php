<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">

    <?php echo $this->render('@frontend/views/site/partials/_userIcon', ['userId' => $model->id]); ?>

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php
            echo Html::a(Yii::t('app', 'Update'),
                ['update'],
                ['class' => 'btn btn-primary']);
        ?>
    </p>

    <?php
        echo DetailView::widget(['model' => $model, 'attributes' => [
            'username:ntext',
            //'password_hash:ntext',
            //'password_reset_token:ntext',
            'email:ntext',
            //'auth_key:ntext',
            //'status',
            //'created_at',
            //'updated_at',
            //'password:ntext',
            //'board_id',
            ],
        ]);
    ?>
</div>
