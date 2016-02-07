<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider, 'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username:ntext',
            'password_hash:ntext',
            'password_reset_token:ntext',
            'email:ntext',
            // 'auth_key:ntext',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'password:ntext',
            // 'board_id',
             ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
