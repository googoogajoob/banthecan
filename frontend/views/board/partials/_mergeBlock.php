<?php
    use yii\helpers\Html;
?>

<div id="merge-block" class="pull-right merge-block">

    <h3><?php echo \Yii::t('app', 'Tickets Selected for Merging'); ?></h3>

    <?php echo Html::beginForm('/ticket/merge', 'post', ['role' => 'form', 'id' => 'merge-form']); ?>

    <ul id="merge-title-list">
    </ul>

    <?php
        echo Html::submitButton(
                \Yii::t('app', 'Merge Tickets'),
                [
                    'class' => 'btn btn-success pull-right',
                    'id' => 'merge-submit-button',
                    'style' => 'display: none'
                ]
        );
        echo Html::endForm();
    ?>
</div>