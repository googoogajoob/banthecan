<?php

namespace common\models\ticketDecoration;

use yii\helpers\Html;
use yii\db\ActiveRecord;
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
        $junk = 'dude';

        return [
            Model::EVENT_BEFORE_VALIDATE => 'validateVote',
        ];
    }

    /**
     * @param Event $event
     */
    public function validateVote($event)
    {
        $junk = 'dude';
/*
        $who = $userRecord = Yii::$app->user->identity;
        $plusVote = ($this->oldAttributes[$attribute] < $this->attributes[$attribute]);

        $junk = $this->getDecorationData();

        if ($plusVote) {
            $this->addError($attribute, \Yii::t('app', 'Plus-Votes for (' . $who->username . ') are forbidden'));
            //$this->addError($attribute, \Yii::t('app', 'Only one vote allowed per user'));
        } else {
            $dude = 1;
        }
*/
    }
}