<?php

namespace common\models\ticketDecoration;

use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/29/15
 * Time: 12:33 AM
 */

class Vote extends AbstractDecoration
{

	public $plusLinkIcon = '+';
    public $minusLinkIcon = '-';


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
        $className = $this->get_my_classname();
        $decorationData = $this->owner->getDecorationData();
        if (isset($decorationData[$className])) {
            $lastVoteChange = $decorationData[$className];
        } else {
            $lastVoteChange = 0;
        }

        if ($lastVoteChange < 0) {
            return '<a data-toggle="tooltip"
					    title="' . \Yii::t('app', 'Vote Plus')
                    . '"href="/ticket/plus/' . $this->owner->id . '">'
                    . $this->plusLinkIcon
                    . '</a>';
        } elseif ($lastVoteChange > 0) {
            return '<a data-toggle="tooltip"
                         title="' . \Yii::t('app', 'Vote Minus')
                        . '"href="/ticket/minus/' . $this->owner->id . '">'
                        . $this->minusLinkIcon
                    .'</a>';
        } else {
            return '<a data-toggle="tooltip"
					    title="' . \Yii::t('app', 'Vote Plus')
                    . '"href="/ticket/plus/' . $this->owner->id . '">'
                    . $this->plusLinkIcon
            . '</a>'
            . '<a data-toggle="tooltip"
                         title="' . \Yii::t('app', 'Vote Minus')
                . '"href="/ticket/minus/' . $this->owner->id . '">'
                . $this->minusLinkIcon
                .'</a>';
        }
	}

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'validateVote',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'saveVote',
        ];
    }

    /**
     * @param Event $event
     */
    public function validateVote($event)
    {
        $voteChange = $this->getVoteChange($event);
        $className = $this->get_my_classname();
        $decorationData = $event->sender->getDecorationData();
        if (isset($decorationData[$className])) {
            if ($voteChange == $decorationData[$className]) {
                $event->sender->addError('vote_priority', \Yii::t('app', 'Only one vote allowed per user'));
            }
        }
    }

    /**
     * @param Event $event
     */
    public function saveVote($event)
    {
        if ($event->sender->isAttributeChanged('vote_priority', false)) {
            $voteChange = $this->getVoteChange($event);
            $className = $this->get_my_classname();
            $decorationData = $event->sender->getDecorationData();
            $decorationData[$className] = $voteChange;
            $event->sender->setDecorationData($decorationData);
        }
    }

    protected function getVoteChange($event) {
        $oldVote = $event->sender->oldAttributes['vote_priority'] ? $event->sender->oldAttributes['vote_priority'] : 0;
        $newVote = $event->sender->attributes['vote_priority'] ? $event->sender->attributes['vote_priority'] : 0;

        return $oldVote < $newVote ? 1 : -1;
    }

    protected function get_my_classname()
    {
        return str_replace('\\', '_', get_class());
    }
}