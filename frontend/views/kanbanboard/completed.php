<?php

use frontend\assets\BanTheCanAsset;

BanTheCanAsset::register($this);
/* @var $tickets common\models\Ticket */
$this->params['breadcrumbs'][] = 'Completed';

echo $this->render('../ticket/_ticketList', ['tickets' => $tickets]);
?>
