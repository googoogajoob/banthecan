<?php

namespace apc\ticketDecoration;

use yii\helpers\Html;

class TaskLink extends Link {

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
        ) . $this->getOpenTaskCountHtml();
    }

    protected function getOpenTaskCountHtml()
    {
        $openTaskCount = $this->owner->getOpenTaskCount();
        if ($openTaskCount > 0) {
            $openTaskCountHtml = '<strong class="text-danger"><small>&nbsp;(' . $openTaskCount . ')</small></strong>';
        } else {
            $openTaskCountHtml = '';
        }

        return $openTaskCountHtml;
    }
}