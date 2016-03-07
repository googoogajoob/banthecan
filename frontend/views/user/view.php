<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];

?>

<div class="user-view">

    <?php echo $this->render('@frontend/views/site/partials/_userIcon', ['userId' => $model->id]); ?>

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php
            echo Html::a(Yii::t('app', 'Edit'),
                ['update'],
                ['class' => 'btn btn-primary']);
        ?>
    </p>

    <?php
        echo DetailView::widget(['model' => $model, 'attributes' => [
            [
                'attribute' => 'username',
                'format' => 'ntext',
                'label' => \Yii::t('app', 'Username'),
            ],
            'email:ntext',
            ],
        ]);
    ?>
</div>
