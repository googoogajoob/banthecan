<?php

use yii\jui\Sortable;
use frontend\controllers\TicketController;

/* @var $this yii\web\View */
/* @var $column common\models\Column */

/**
 * Erkenntnisblitz: I was having difficulty using the Bootstrap grid features to arrange the columns
 * the way I wanted. I need different margins, padding etc. but why should I change the Bootstrap classes?
 * The it dawned on me. I don't need to pack everything I'm doing directly in the column grid Div elements.
 * The Column Gird Div Elements can be used as a skeleton upon which (or within which) I place my column stuff
 * i.e. other Divs. This way I can let Bootstrap do it's responsive stuff, wrapping etc. acting upon the
 * outer layers of Div elements.My stuff on the inside is just along for the ride and does'nt really care
 * what Bootstrap is doing. It's almost like each grid element is providing me a fresh new "canvas" from
 * which I can "paint" the stuff that needs to be there.
 */

defined('COLUMN_ID_PREFIX') or define('COLUMN_ID_PREFIX', 'boardColumn_');

?>

<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">

<h4 class="board-column-title"><?php echo $column->title; ?></h4>

<?php
// Get the HTML of all ticket content for this column concatenated into one string
$columnItems = [];
foreach($column->getTickets() as $ticket) {
	$content = $this->render('@frontend/views/ticket/partials/_ticketSingle',[
                'model' => $ticket,
                'showTags' => true,
	]);
	$options = [
                'id' => TicketController::TICKET_HTML_PREFIX . $ticket->id,
                'tag' => 'div',
                'class' => 'ticket-widget',
	];
	$columnItems[] = [
                'content' => $content,
                'options' => $options,
	];
}

// create the column as a sortable widget container
// --------------------------------------------------------
// Read the serialized list of Column Ids and create for it
// a comma separated list of the ID's with COLUMN_ID_PREFIX prepended to the ID
if (trim($column->receiver) <> '') {
	$connectedColumns = explode(',', $column->receiver);
	$prefix = '#' . COLUMN_ID_PREFIX;
	$separator = ', #' . COLUMN_ID_PREFIX;
	$connectedColumns = $prefix . implode($separator, $connectedColumns);
} else {
	$connectedColumns = '';
}

echo Sortable::widget([
            'items' => $columnItems,
            'options' => ['id' => COLUMN_ID_PREFIX . $column->id, 'tag' => 'div', 'class' => 'board-column'],
            'clientOptions' => [
                'cursor' => 'move',
                'connectWith' => $connectedColumns,
],
            'clientEvents' => [
                'activate' => 'function (event, ui) {
                    showColumnReceiver(event, ui, this);
                }',
                'deactivate' => 'function (event, ui) {
                    hideColumnReceiver(event, ui, this);
                }',
                'receive' => 'function (event, ui) {
                    columnTicketOrder(event, ui, this);
                }',
                'update' => 'function (event, ui) {
                    if (!ui.sender && this === ui.item.parent()[0]) {
                       columnTicketOrder(event, ui, this);
                    }
                }',
],
]);
?></div>

