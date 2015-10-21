<?php

namespace common\models\ticketDecoration;

/**
 * The Decoration Interface defines the common interface to be implemented
 * by The Decoration Behavior classes, which are configured within columns and
 * used as behaviors withing individual tickets.
 *
 * The Ticket Decoration Concept
 * =============================
 * A ticket decoration is an optional functionality of a ticket which performs a specialized task. Examples would be
 * Moving a Ticket to the Backlog, KanBan or Completed Boards, Blocking the movement of a ticket to another column
 * based on specific conditions, creating another object such as a "ToDo" task, or voting on a protocol before
 * a ticket can be considered completed.
 *
 * Decorations are implemented as behaviors of the ticket class. The existence of a decoration in a ticket is determined
 * by the column where a ticket is located (as well as the backlog and completed areas). Columns contain a set of decoration
 * requirements (and/or) possibilities. As a ticket is moved from one column to another, the column, where a ticket is located,
 * dictates which behaviors the ticket implements.The requirements of columns upon tickets is a configurable setting in the
 * design of a Board and its columns.
 *
 * (note of explanation): TicketDecorations are Yii-Behaviors applied to the Ticket Class.
 *                        Thus, "TicketDecoration" and "Behavior" are used interchangeably.
 *
 * The requirements of the various participants are as follows:
 * ------------------------------------------------------------
 * Columns:
 *     - Maintain a list of decorations that are to be implemented in the column
 *          - Implementation:
 *              - Columns: keep a list of ticketDecorations for the column.This requires a unique
 *                type-identifier for each behavior type
 *     - Maintain the configuration for how each behavior is to be implemented in this column's tickets
 *          - Implementation
 *              - Columns: maintain(persist) configuration date for the ticketDecorations
 *              - TicketDecoration:Deliver/Receive Configuration options
 *     - Inform the tickets about what behaviors are expected of them
 *          - Implementation
 *              - TicketDecoration: Receive Configuration options
 *              - TicketDecoration: Instantiate itself according to the configuration options
 *
 * Tickets:
 *     - Dynamically allow the implementation of any behavior
 *          - Implementation
 *              - TicketDecoration: Instantiate a TicketDecoration Behavior (all types)
 *     - Allow for the persistence of a behaviors status for that ticket (serialized field)
 *          - Implementation
 *              - Ticket: persist the status of each behavior
 *              - Behavior: Get/(allow)Set the behavior status
 * 
 * Behaviors (see file "TicketDecorationAnalysis.ods" for information about the conceptual planning):
 *     - Uniquely Identify itself
 *          - Implementation: Ticket Decoration Manager knows the IDs of each Behavior Type
 *     - Provide its name and description
 *          - Implementation: TicketDecoration Behavior can supply both attributes
 *     - Instantiate itself (see above)
 *     - Get/Set Configuration Data
 *     - Get/Set Ticket Persistence Data
 *     - Show (implementation within the TicketDecoration Behaviors)
 *          - Default is to show itself as an icon within the ticket, in order to start (activate) the decoration
 *          - For some decorations addition show options may be needed, these must be callable via the
 *            show method using an additional ID parameter (0, 1, 2, 3 ...)
 *
 * @author Andrew Potter <apc@andypotter.org>
 */
interface TicketDecorationInterface {

    /**
     * Show a view of the Behavior
     * The default is the Icon Click element
     * A Decoration can have multiple views
     *
     * @return string html for showing the ticketDecoration
     */
    public function show($view = 'default');
}
