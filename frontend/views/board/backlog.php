<?php

use frontend\assets\BanTheCanAsset;

BanTheCanAsset::register($this);

/* @var $tickets common\models\Ticket */

$this->params['breadcrumbs'][] = 'Backlog';

echo $this->render('@frontend/views/ticket/_ticketList', ['tickets' => $tickets]);
?>
