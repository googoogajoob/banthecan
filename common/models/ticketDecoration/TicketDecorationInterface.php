<?php

namespace common\models\ticketDecoration;

/**
 * The Decoration Interface defines the common interface to be implemented
 * by The Decoration Behavior classes, which are configured within columns and
 * used as behaviors withing individual tickets.
 *
 * The Ticket Decoration Concept
 * =============================
 * A ticket decoration is an optional functionality of a ticket for performing a specialized task. Examples would be
 * Blocking/Allowing the movement of a ticket to another column based on specific conditions, creating another object
 * such as a "ToDo" task, or voting on a protocol before a ticket can be considered completed.
 *
 * Decorations are to be implemented as behaviors of the ticket class. Therefore they interact with the ticket,
 * its view and its 'business' logic  However, the existence of a decoration in a ticket is determined by the column
 * where a ticket is located. Columns contain a set of decoration requirements (and/or) possibilities. As a ticket is
 * moved from one column to another, the column, where a ticket is located, dictates which behaviors a ticket
 * can (or must) implement. The requirements of columns upon tickets is a configurable setting in the design
 * of a Board.
 *
 * The requirements of the various participants is as follows:
 * ----------------------------------------------------------------
 * Columns:
 *     - Maintain a list of decorations that are to be implemented in this column
 *     - Maintain the configuration for how each behavior is to be implemented in this column's tickets
 *     - Inform the tickets about what behaviors are expected of them
 *
 * Tickets:
 *     - Dynamically allow the implementation of any behavior
 *     - Allow for the persistence of a behaviors status for that ticket (serialized field)
 * 
 * Behaviors (see file "TicketDecorationAnalysis.ods" for information about the conceptual planning):
 *     - Uniquely Identify itself
 *     - Provide its name and description
 *     - Instantiate itself
 *     - Perform all MVC functions that a behavior needs
 *     - Get/Set Configuration Data
 *     - Get/Set Ticket Persistence Data
 *     - Show
 *          - Default is to show itself as an icon within the ticket, in order to start (activate) the decoration
 *          - For some decorations addition show options may be needed, these must be callable via the
 *            show method using an additional ID parameter (0, 1, 2, 3 ...)
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
