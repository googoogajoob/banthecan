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
        ) . $this->getTaskCountIndicatorHtml();
    }

    protected function getTaskCountIndicatorHtml()
    {
        $openTaskCount = $this->owner->getOpenTaskCount();
        $closedTaskCount = $this->owner->getClosedTaskCount();

        if ($openTaskCount > 0) {
            $openTaskCountHtml = '<strong class="text-danger"><small>&nbsp;(' . $openTaskCount . ')</small></strong>';
        } elseif ($closedTaskCount > 0) {
            $openTaskCountHtml = '<strong class="text-success"><small>&nbsp;<span class="glyphicon glyphicon-ok"></span></small></strong>';
        } else {
            $openTaskCountHtml = '';
        }

        return $openTaskCountHtml;
    }

    public function getLinkUrl()
    {
        $openTaskCount = $this->owner->getOpenTaskCount();
        $closedTaskCount = $this->owner->getClosedTaskCount();

        if ($openTaskCount > 0) {
            $returnUrl = $this->showUrl . $this->owner->id;
        } elseif ($closedTaskCount > 0) {
            $returnUrl = $this->showUrl . $this->owner->id . '&TaskSearch[completed]=1';
        } else {
            $returnUrl = $this->showUrl . $this->owner->id;
        }

        return $returnUrl;
    }
}