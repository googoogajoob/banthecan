<?php

namespace apc\ticketDecoration;

use yii\helpers\Html;

class Merge extends AbstractDecoration {

	public $linkIcon = 'L';

	public function render()
	{
        return Html::a(
            $this->linkIcon,
            '',
            [
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => \Yii::t('app', $this->title),
                'onclick' => 'addTicketToMerge('
                    . $this->owner->id
                    . ', '
                    . '"' . $this->owner->title . '"'
                    . '); preventBubbling(event); return false;',
                'class' => 'text-muted',
            ]
        );
    }

	public function getLinkUrl()
	{
		return '#';
	}
}