<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 10/15/15
 * Time: 8:22 PM
 */

namespace common\models\ticketDecoration;

use common\models\Ticket;
use common\models\Board;
use common\models\Column;
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
	 * @return array Keys of configured decoration classes
	 */
	public function getAvailableTicketDecorations()
    {
		return array_keys($this->_availableTicketDecorations);
	}

    public function getTicketDecorationTitle($decorationKey)
    {
        if (array_key_exists($decorationKey, $this->_availableTicketDecorations)) {
            if (array_key_exists('title', $this->_availableTicketDecorations[$decorationKey])) {
                $decorationTitle = $this->_availableTicketDecorations[$decorationKey]['title'];
            } else {
                $decorationTitle = 'Ticket Decoration';
            }
        }

        return \Yii::t('app', $decorationTitle);
    }

	/**
	 * Returns the configuration arrays for the current set of active ticket decorations
	 * @param $column integer
	 * @return array
	 */
	public function getActiveTicketDecorations($column)
    {
        if (!isset($this->_activeTicketDecorations[$column])) {
            $configuredDecorations = $this->getConfiguredDecorations($column);

            if (is_array($configuredDecorations)) {
                foreach ($configuredDecorations as $decoration) {
                    if ($decoration != null && isset($this->_availableTicketDecorations[$decoration])) {
                        $this->_activeTicketDecorations[$column][] = $this->_availableTicketDecorations[$decoration];
                    }
                }
            } else {
                return null;
            }
        }

        return $this->_activeTicketDecorations[$column];
	}

    protected function getConfiguredDecorations($column)
    {
        if ($column == Ticket::DEFAULT_BACKLOG_STATUS
         || $column == Ticket::DEFAULT_COMPLETED_STATUS) {

            if ($board = Board::getActiveBoard()) {
                $decorations = $column == Ticket::DEFAULT_BACKLOG_STATUS
                                ? $board->ticket_backlog_configuration
                                : $board->ticket_completed_configuration;
                return $decorations;
            }

        } else {

            if ($column = Column::findOne($column)) {
                return $column->ticket_column_configuration;
            }
        }

        return null;
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