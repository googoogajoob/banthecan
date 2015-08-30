<?php

namespace common\models\ticketDecoration;

/**
 * DecorationInterface defines the common interface to be implemented by Decoration Implementation classes.
 *
 * The decorations are implemented as Yii-behaviors to the column class,
 * thus the necessary functionality for Yii-behaviors is also required
 *
 * The Ticket Decoration Concept
 * =============================
 * A ticket decoration is an optional functionality of a ticket for performing a specialized task. Examples would be
 * Blocking/Allowing the movement of a ticket to another column based on specific conditions, create another object such as a task
 * from a ticket or voting on a protocol before a ticket can be completed.
 *
 * Decorations are to be implemented as behaviors of the ticket class. Therefore the interact with the ticket, its view and
 * its 'business' logic  However, the existence of a decoration in a ticket is determined by the column where a ticket is 
 * located. Columns contain a set of decoration requirements (and/or) possibilities. As a ticket is moved from one column to 
 * another, the column dictates which behaviors a ticket can (or must) implement.
 *
 * The, the requirements of the various participants is as follows:
 * ----------------------------------------------------------------
 * Columns:
 *     Maintin a list of decorations that are to be implemented in this column (CRUD)
 *     Persistance (likely with a serialized of CSV field of Decoration Type-IDs)
 *     Tell Tickets what behaviors are required of them (clear behaviors of a ticket, when it is moved to a new column) 
 *     Currently The columns determine where tickets can move  
 *
 * Tickets:
 *     Must be able to dynamicaly allow the implementation of any behavior
 *     Must allow for persistance of a behaviors status for that ticket (serialized field)
 * 
 * Behaviors:
 *     Uniquely Identify itself
 *		 Provide its name and description 
 *     Perform all MVC functions that a behavior needs
 *
 * @author Andrew Potter <apc@andypotter.org>
 */
interface TicketDecorationInterface {

/* Methods sre Sorted according to MVC Architecture */
/* ============================================ */

/* Controller Related Methods */
/* ========================== */

	/** Currently Empty, no Controller functions 
	 *  As the decorations are behaviors I see no need for controller functioanlity (yet?)
	 */ 

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
