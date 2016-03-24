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
		return '<a data-toggle="tooltip"
					title="' . \Yii::t('app', 'Vote Plus')
					. '"href="/ticket/plus/' . $this->owner->id . '">'
					. $this->linkIcon
				.'</a>';
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
        $who = \Yii::$app->user->identity;
        $plusVote = ($event->sender->oldAttributes['vote_priority'] < $event->sender->attributes['vote_priority']);
        $decorationData = unserialize($event->sender->decoration_data);
        $lastVote = $decorationData['votePlus'];
        if ($plusVote) {
            if ($lastVote > 0) {
                $event->sender->addError('vote_priority', \Yii::t('app', 'Only one vote allowed per user'));
            }
        } else {
            if ($lastVote < 0) {
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
            $lastVote = $event->sender->oldAttributes['vote_priority'] < $event->sender->attributes['vote_priority'] ? 1 : -1;
            $decorationData = unserialize($event->sender->decoration_data);
            $decorationData['votePlus'] = $lastVote;
            $event->sender->decoration_data = serialize($decorationData);
        }
    }
}