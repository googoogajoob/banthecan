# The BanTheCan Project (Ban The Can)

This project implements a Kanban Board systems. It is written using **yii2** and is thus a web based PHP/MySql application.

It is still in the **Alpha Stage**

It offers the following options:
* Multiple Boards
* Users and Groups with rights to particular boards
* Definition of Board Columns and Lanes
* Ticket entry system
* Rules governing how tickets can be moved between columns and lanes
* A visual view of the columns and tickets offering Ajax Drag and Drop for ticket manipulation
* A View of statistics from the board
* The Statistics are implements with specific widgets which can be defined per user

## What is BanTheCan?

**Ban the Can** is a specialized implementation of a Kanban Board. It was developed in an attempt to help organizations that operate primarily with the discussion of topics. This differs from the use of a Kanban board in a <a href="http://en.wikipedia.org/wiki/Kanban">production environment</a>, such as physical products or software development. Nonetheless it may prove helpful for usage which goes beyond its original intent.

Examples of organizations that operate on a discussion level would be sports-clubs, political organizations or churches. In such organizations specific topic are discussed on a regular basis. The focal point is not production but development of a consensus. **Ban the Can** was designed to help organize such a process.

## How can Ban the Can help me?
* Allow users to create discussion topics in the form of **tickets**, creating a **backlog** of possible discussion topics
* Select **tickets** from the the **backlog** and place them in the current **board** for the next discussion. This is aided by the use of filters and tags so that one can adequately prioritize the ticket pool in the **backlog**.
* Once topics are in the **board** they can be placed in columns indicating various stages of a discussion process. The columns can be specified to fit your needs. **For example**:
  * Waiting to be discussed
  * Discussed but waiting for an external event
  * In discussion
  * Consensus achieved
  * An action has been assigned
  * Protocol has been written
* Rules can be implemented to specify the workflow, i.e. how must the **tickets** travel through the various columns.
* Once the **tickets** are completed they can be marked as such and then are no longer part of the active board. At this point completed tickets can be reviewed using filters, tags and other searching options. This is advantageous for creating reports if what topics have been discussed over a specific period.
* Multiple **boards** can be defined, each having its own set of columns and rules as well as keeping the **tickets** organized per board.
* Users can be member of specific boards and be given rights to execute specific functions. For example if one person is responsible for the protocol, they alone can be given the access rights to do so.

