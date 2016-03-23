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

	private $_activeTicketDecorations = [];
	private $_availableTicketDecorations = [];


	/**
	 * @param $decorations array
	 * @return $this common\models\ticketDecoration\TicketDecorationManager
	 */
	public function setAvailableTicketDecorations($decorations) {
		$this->_availableTicketDecorations = $decorations;

		return $this;
	}

	/**
	 * @return array Keys, i.e. class names of available decorations
	 */
	public function getAvailableTicketDecorations() {
		return array_keys($this->_availableTicketDecorations);
	}

	/**
	 * Returns the configuration arrays for the current set of active ticket decorations
	 * @param $column integer
	 * @return array
	 */
	public function getActiveTicketDecorations($column) {
		return $this->_activeTicketDecorations;
	}

	/**
	 * Is $className an available ticket decoration
	 *
	 * @return boolean
	 */
	public function isAvailable($className) {
		return array_key_exists($className, $this->_availableTicketDecorations);
	}

	/**
	 * Is $className an active ticket decoration
	 *
	 * @return boolean
	 */
	public function isActive($className) {
		return array_key_exists($className, $this->_activeTicketDecorations);
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