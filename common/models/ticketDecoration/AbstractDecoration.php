<?php

namespace common\models\ticketDecoration;

use yii\base\Behavior;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/27/15
 * Time: 2:06 AM
 */

abstract class ticketDecoration extends Behavior implements ticketDecorationInterface {

    private $_configurationData = array();
    private $_decorationData = array();

    /**
     * Performs the tasks or functions that a ticketDecoration is designed to do
     * @return boolean success or failure
     */
    abstract public function doDecoration();

    /**
     * Returns the Configuration Data of the Decoration.
     * This is what the column stores for the configuration of the decoration
     *
     * @return array of key value pairs
     */
    public function getConfigurationData() {
		return $this->_configurationData;
	 }

    /**
     * Set the Configuration Data of the Decoration.
     * This is what the column stores for the configuration of the decoration
     *
     * @param array of key value pairs
     * @return $this
     */
    public function setConfigurationData($config = array()){
		$this->_configurationData = $config;
		
		return $this;
	 }

    /**
     * Returns the Decoration Data of the Decoration.
     * This is what the ticket stores for the persistence of the decoration
     *
     * @return array of key value pairs
     */
    public function getDecorationData() {
		return $this->_decorationData;
	 }

    /**
     * Sets the Decoration Data of the Decoration.
     * This is what the thicket stores for the persistence of the decoration
     *
     * @return $this
     */
    public function setDecorationData($config = array()) {
		$this->_decorationData = $config;
		
		return $this;
	 }

    /**
     * Show a view of the Behavior
     * The default is the Icon Click element
     * A Decoration can have multiple views
     *
     * @return string html for showing the ticketDecoration
     */
    abstract public function show($view = 'default');
}
