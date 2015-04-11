<?php

use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $ticketRecord common\models\Ticket */

$ticketViewUrl = Url::to(['ticket/view', 'id' => $ticketRecord['id']]);
?>

    <div class="ticket-avatar">
        <?php echo $this->render('@frontend/views/site/_userIcon', ['userId' => $ticketRecord['created_by']]);?>
    </div>

    <strong><a href="<?php echo $ticketViewUrl; ?>"><?php echo $ticketRecord['title']?></a></strong><br />

    <div class="clear-both"></div>

    <?php echo Yii::$app->formatter->asDate($ticketRecord['created_at'], 'long'); ?>
    <br /><br />
    <?php echo StringHelper::truncate($ticketRecord['description'], 100, ' ...'); ?>
