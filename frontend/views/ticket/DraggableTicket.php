<?php

namespace frontend\views\ticket;

use yii\jui\Draggable;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

class DraggableTicket extends Draggable {

//    <strong><?php echo $ticket['title'] ? ></strong><br/>
//    <?php echo $ticket['assignedName'] ? ><br/>
//    <?php echo Yii::$app->formatter->asDate($ticket['created'], 'long'); ? >
//    <br/><br/>
//    <?php echo StringHelper::truncate($ticket['description'], 100, ' ...'); ? >
    /**
     * Initializes the widget.
     */
    protected function ticketContent () {
        return echo 'dude';
    }
    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->ticketContent();
        parent::run();
    }

}
