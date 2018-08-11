<?php
    use yii\helpers\Html;
?>

<div id="merge-block" class="pull-right merge-block">

<?php
    echo \Yii::t('app', 'Tickets Selected for Merging');
    echo Html::beginForm('/ticket/merge', 'post', ['role' => 'form']);
    echo Html::submitButton(\Yii::t('app', 'Merge Tickets'), ['class' => 'btn btn-success']);
    echo Html::endForm();
?>

</div>