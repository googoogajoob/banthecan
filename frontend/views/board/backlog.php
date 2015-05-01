<?php

/* @var $tickets common\models\Ticket */

$this->params['breadcrumbs'][] = 'Backlog';

echo $this->render('@frontend/views/ticket/_ticketList', ['tickets' => $tickets]);
?>
