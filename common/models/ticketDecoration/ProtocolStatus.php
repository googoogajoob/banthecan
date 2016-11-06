<?php

namespace common\models\ticketDecoration;

use yii\helpers\Html;

class ProtocolStatus extends AbstractDecoration {

	public $linkIcon = 'P';

	/*##################*/
	/*### VIEW STUFF ###*/
	/*##################*/

	/**
	 * Show the protocol status the Behavior
	 *
	 * @return string html for showing the ticketDecoration
	 */
	public function show($view = 'default')
	{
		$returnValue =
			'<div data-toggle="tooltip" data-placement="bottom" title="' . \Yii::t('app', 'Protocol Status') . '">'
			. Html::a(
				$this->linkIcon,
				'/ticket/view/' . $this->owner->id, [
					'data-toggle' => 'modal',
					'data-target' => '#global-modal-container',
				]
			)
			. '</div>';

		return $returnValue;
	}

}