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

    /**
     * This is intended for situations like a drop-down menu selection box.
     */
    public $name = 'Abstract Ticket Decoration';

    /**
     * Performs the tasks or functions that a ticketDecoration is designed to do
     * when it is invoked.
     *
     * @return boolean success or failure
     */
    abstract public function performTask();

    /**
     * Updates the ticketDecoration/behavior
     *
     * Are other CRUD Methods needed?
     *
     * @return $this the ticketDecoration behavior itself
     */
    abstract public function update();


    /**
     *
     * @return $this a ticketDecoration object
     */
    static public function create();

    /**
     * Sets the movement conditions
     *
     * @return array conditions array
     */
    public function setConditions($conditions);

    /**
     * Gets the movement conditions
     *
     * @return array conditions array
     */
    public function getConditions();

    /**
     * Sets the applied array
     * where am I to be applied (Columns/backlog/completed)
     *
     * @return array applied array
     */
    public function setApplied($applied);

    /**
     * Gets the applied array
     * where am I to be applied (Columns/backlog/completed)
     *
     * @return array applied array
     */
    public function getApplied();

    /**
     * Sets the visibility array
     * where am I to be visible (Columns/backlog/completed)
     *
     * @return array visible array
     */
    public function setVisible($visibility);

    /**
     * Gets the visible array
     * where am I to be visible (Columns/backlog/completed)
     *
     * @return array visible array
     */
    public function getVisible();

    /**
     * Sets the enables array
     * where am I enabled (Columns/backlog/completed)
     *
     * @return array enabled array
     */
    public function setEnabled($enabled);

    /**
     * Gets the visible array
     * where am I enabled (Columns/backlog/completed)
     *
     * @return array enabled array
     */
    public function getEnabled();

    /* View Related Methods */
    /* ==================== */
    /**
     * Show myself (in a functional situation)
     *
     * @return string html for showing the ticketDecoration
     */
    public function show();

    /**
     * Show myself (in a editable situation)
     *
     * @return string html for editing the ticketDecoration
     */
    public function showEdit();

    /**
     * Describe the capabilities of the ticketDecoration
     *
     * @return string html for the description of the ticketDecoration's capabilities
     */
    public function describe();
    // What can I do, description of functionality

}
