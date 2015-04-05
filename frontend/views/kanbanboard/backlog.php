<?php

use frontend\assets\BanTheCanAsset;

BanTheCanAsset::register($this);
/* @var $tickets common\models\Ticket */
$this->params['breadcrumbs'][] = 'Backlog';

echo $this->render('../ticket/_ticketList', ['tickets' => $tickets]);
?>
