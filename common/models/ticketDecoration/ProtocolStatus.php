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
	public function render()
	{
		$returnValue =
			'<div data-toggle="tooltip" data-placement="bottom" title="' .
			\Yii::t('app', $this->title) . '">'
			. Html::a(
				$this->linkIcon,
				$this->showUrl . $this->owner->id, [
					'data-toggle' => 'modal',
					'data-target' => '#global-modal-container',
				]
			)
			. '</div>';

		return $returnValue;
	}

}