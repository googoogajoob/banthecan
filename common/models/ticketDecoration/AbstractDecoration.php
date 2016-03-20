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
    public $decorationData = null;

	/**
	 * Show a view of the Behavior
	 * The default is the Icon Click element
	 * A Decoration can have multiple views
	 *
	 * @return string html for showing the ticketDecoration
	 */
	abstract public function show($view = 'default');
}
