<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $avatar string */
/* @var $timestamp integer */

?>

<div class="pull-left img-responsive" style="margin-right: 4px;">
    <?php
        if ($avatar) {
            echo Html::img($avatar);
        }
    ?>
</div>
<strong>
    <em>
        <?php
            if ($name) {
                echo $name;
            }
        ?>
    </em>
</strong>

<?php if (isset($timestamp)) : ?>
    <br/>
    <span><?php echo Yii::$app->formatter->asDate($timestamp, 'short'); ?></span>
<?php endif; ?>