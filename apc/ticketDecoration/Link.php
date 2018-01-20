<?php

namespace apc\ticketDecoration;

use yii\helpers\Html;

class Link extends AbstractDecoration {

	public $linkIcon = 'L';

	public function render()
	{
        return Html::a(
            $this->linkIcon,
            $this->getLinkUrl(), [
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => \Yii::t('app', $this->title),
                'onclick' => 'return preventBubbling(event);',
                'class' => 'text-muted',
            ]
        );

    }

	public function getLinkUrl()
	{
		return $this->showUrl . $this->owner->id;
	}
}