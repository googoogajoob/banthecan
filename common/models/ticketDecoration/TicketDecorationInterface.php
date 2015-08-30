<?php

namespace common\models\ticketDecoration;

/**
 * DecorationInterface defines the common interface to be implemented by Decoration Implementation classes.
 *
 * The decorations are implemented as Yii-behaviors to the column class,
 * thus the necessary functionality for Yii-behaviors is also required
 *
 * @author Andrew Potter <apc@andypotter.org>
 */
interface TicketDecorationInterface {

/* Methods sre Sorted according to MVC Architecture */
/* ============================================ */

/* Controller Related Methods */
/* ========================== */

/* MODEL Related Methods */
/* ===================== */
    /**
     * Performs the tasks or functions that a ticketDecoration is designed to do
     * @return boolean success or failure
     */
    public function performTask();

    /**
     * Updates the ticketDecoration/behavior
     *
     * Are other CRUD Methods needed?
     *
     * @return $this the ticketDecoration behavior itself
     */
    public function update();

    /**
     * Returns the Name of the Decoration. This is intended for situations
     * like a drop-down menu selection box.
     *
     * @return string Name of the Decoration
     */
    public function whoAmI();

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
