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
    public $dataKey = 'defaultDataKey'; //Data storage in the ticket itself
    public $displaySection = null;
    public $movement = false;
    public $sortOrder = 0;
    public $showUrl = '';
    public $renderView = '@frontend/views/ticket/partials/decoration/link';
    public $title = ''; //Link Help title

	/**
	 * Renders the ticket decoration usinf the configured view file
	 *
	 * @return string html for showing the ticketDecoration
	 */
	abstract public function render();

    /**
     * Gets the decoration Data from the ticket and returns the portion for this Behaviors DecorationKey
     */
    public function getDecorationData()
    {
        $ownerDecorationData = $this->owner->getDecorationData();
        $classNameKey = $this->get_my_classname();
        if (isset($ownerDecorationData[$classNameKey])
            && isset($ownerDecorationData[$classNameKey][$this->dataKey])) {

            return $ownerDecorationData[$classNameKey][$this->dataKey];

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
        $ownerDecorationData[$classNameKey][$this->dataKey] = $newData;
        $this->owner->setDecorationData($ownerDecorationData);

        return $this;
    }

    protected function get_my_classname()
    {
        return str_replace('\\', '_', get_class($this));
    }

}
