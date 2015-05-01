<?php

/* @var $tickets common\models\Ticket */

$this->params['breadcrumbs'][] = 'Completed';

echo $this->render('@frontend/views/ticket/_ticketList', ['tickets' => $tickets]);
?>
