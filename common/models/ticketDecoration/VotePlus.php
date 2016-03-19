<?php

namespace common\models\ticketDecoration;

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/29/15
 * Time: 12:33 AM
 */

class VotePlus extends AbstractDecoration
{

	public $linkIcon = '+';

	/*##################*/
	/*### VIEW STUFF ###*/
	/*##################*/

	/**
	 * Show a view of the Behavior
	 * The default is the Icon Click element
	 * A Decoration can have multiple views
	 *
	 * @return string html for showing the ticketDecoration
	 */
	public function show($view = 'default')
	{
		return Html::tag(
            'div',
		$this->linkIcon, [
                'onClick' => 'ticketDetailView(' . $this->owner->id . ');',
                'data-toggle' => 'tooltip',
                'title' => 'Vote Plus',
		]
		);
	}
}