<?php

namespace common\models\ticketDecoration;

use yii\base\Behavior;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/27/15
 * Time: 2:06 AM
 */

abstract class AbstractDecoration extends Behavior implements TicketDecorationInterface {

	public $linkIcon = '?'; // Default Icon for the Abstract Class, others should override this
    public $decorationKey = 'default';
    public $displaySection = null;
    public $movement = false;

	/**
	 * Show a view of the Behavior
	 * The default is the Icon Click element
	 * A Decoration can have multiple views
	 *
	 * @return string html for showing the ticketDecoration
	 */
	abstract public function show($view = 'default');

    /**
     * Gets the decoration Data from the ticket and returns the portion for this Behaviors DecorationKey
     */
    public function getDecorationData()
    {
        $ownerDecorationData = $this->owner->getDecorationData();
        $classNameKey = $this->get_my_classname();
        if (isset($ownerDecorationData[$classNameKey])
            && isset($ownerDecorationData[$classNameKey][$this->decorationKey])) {

            return $ownerDecorationData[$classNameKey][$this->decorationKey];

        } else {

            return [];
        }
    }

    /**
     * Updates the decoration data for this decorationKey,
     * merges it with the complete decoration data stored in the corresponding ticket
     * and then updates the ticket's decoration data record
     */
    public function setDecorationData($newData)
    {
        $ownerDecorationData = $this->owner->getDecorationData();
        $classNameKey = $this->get_my_classname();
        $ownerDecorationData[$classNameKey][$this->decorationKey] = $newData;
        $this->owner->setDecorationData($ownerDecorationData);

        return $this;
    }

    protected function get_my_classname()
    {
        return str_replace('\\', '_', get_class($this));
    }

}
