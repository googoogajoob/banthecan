<?php

namespace common\models\ticketDecoration;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/29/15
 * Time: 12:33 AM
 */

class MoveToKanban extends AbstractDecoration {

	public $linkIcon = 'K';

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
	public function render() {
		return '<a data-toggle="tooltip"  data-placement="bottom"
					title="' . \Yii::t('app', $this->title)
					. '"href="' . $this->showUrl . $this->owner->id . '">'
					. $this->linkIcon
				.'</a>';
	}

}