<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 10/15/15
 * Time: 8:22 PM
 */

namespace common\models\ticketDecoration;

use common\models\Ticket;
use yii;
use yii\base\Object;


class TicketDecorationManager extends Object {

    private $_availableTicketDecorations;
    private $_activeTicketDecorations = [];


    /**
     * @param $decorations array
     * @return $this common\models\ticketDecoration\TicketDecorationManager
     */
    public function setAvailableTicketDecorations($decorations) {
        $this->_availableTicketDecorations = $decorations;

        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableTicketDecorations() {
        return $this->_availableTicketDecorations;
    }

    /**
     * Returns the configuration arrays for the current set of active ticket decorations
     *
     * @return array
     */
    public function getActiveTicketDecorations() {
        return $this->_activeTicketDecorations;
    }

    /**
     * Extract the specified ticket decorations from the list of available configurations
     * and place them in the list of currently active decoration configurations
     *
     * @param $classNames array
     * @return $this common\models\ticketDecoration\TicketDecorationManager
     */
    public function registerDecorations($classNames = null) {
        $this->_activeTicketDecorations = []; // Start with empty list (reset) and add the new classes

        if (is_array($classNames)) {
            foreach ($classNames as $className) {
                if (array_key_exists($className, $this->_availableTicketDecorations)) {
                    $this->_activeTicketDecorations[$className] = $this->_availableTicketDecorations[$className];
                }
            }
        }

        return $this;
    }
}