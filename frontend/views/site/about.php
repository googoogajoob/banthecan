<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'What is Ban The Can?';
?>
<div class="site-about">
<h1><?= Html::encode($this->title) ?></h1>

<p><strong><em>Ban the Can</em></strong> is a specialized implementation
of a Kanban Board. It was developed in an attempt to help organizations
that operate primarily with the discussion of topics. This differs from
the use of a Kanban board in a <a
	href="http://en.wikipedia.org/wiki/Kanban">production environment</a>,
such as physical products or software development. Nonetheless it may
prove helpful for usage which goes beyond its original intent.</p>

<p>Examples of organizations that operate on a discussion level would be
sports-clubs, political organizations or churches. In such organizations
specific topic are discussed on a regular basis. The focal point is not
production but development of a consensus. <strong><em>Ban the Can</em></strong>
was designed to help organize such a process.</p>

<h2>How can <strong><em>Ban the Can</em></strong> help you?</h2>
<ul>
	<li>Allow users to create discussion topics in the form of <strong>tickets</strong>,
	creating a <strong>backlog</strong> of possible discussion topics</li>
	<li>Select <strong>tickets</strong> from the the <strong>backlog</strong>
	and place them in the current <strong>board</strong> for the next
	discussion. This is aided by the use of filters and tags so that one
	can adequately prioritize the ticket pool in the <strong>backlog</strong>.</li>
	<li>Once topics are in the <strong>board</strong> they can be placed in
	columns indicating various stages of a discussion process. The columns
	can be specified to fit your needs.<br />
	<strong>For example</strong>:
	<ul>
		<li>Waiting to be discussed</li>
		<li>Discussed but waiting for an external event</li>
		<li>In discussion</li>
		<li>Consensus achieved</li>
		<li>An action has been assigned</li>
		<li>Protocol has been written</li>
	</ul>
	</li>
	<li>Rules can be implemented to specify the workflow, i.e. how must the
	<strong>tickets</strong> travel through the various columns.</li>
	<li>Once the <strong>tickets</strong> are completed they can be marked
	as such and then are no longer part of the active board. At this point
	completed tickets can be reviewed using filters, tags and other
	searching options. This is advantageous for creating reports if what
	topics have been discussed over a specific period.</li>
	<li>Multiple <strong>boards</strong> can be defined, each having its
	own set of columns and rules as well as keeping the <strong>tickets</strong>
	organized per board.</li>
	<li>Users can be member of specific bords and be given rights to
	execute specific functions. For example if one person is responsible
	for the protocol, they alone can be given the access rights to do so.</li>
</ul>
</div>
