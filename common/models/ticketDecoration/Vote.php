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
    public $voteAttribute = 'vote_priority';

	/**
	 * Show a view of the Behavior
	 * The default is the Icon Click element
	 *
	 * @return string html for showing the ticketDecoration
	 */
	public function show($view = 'default')
	{
        $currentUserId = \Yii::$app->user->identity->id;
        $decorationData = $this->getDecorationData();

        if (isset($decorationData[$currentUserId])) {


            $lastVoteChange = $decorationData[$currentUserId];
        } else {

            $lastVoteChange = 0;
        }

        if ($lastVoteChange == 0) {

            return $this->linkHtml(1)
                 . $this->linkHtml(-1);

        } else {

            return $this->linkHtml($lastVoteChange * -1);
        }
	}

    /**
     * Creates the html for  a voting link Icon
     *
     * @param $plusMinus 1- Plus HTML, -1 - Minus Html
     * @return string
     */
    protected function linkHtml($plusMinus)
    {
        $title = $plusMinus > 0 ? 'Vote Plus' : 'Vote Minus';
        $icon = $plusMinus > 0 ? $this->plusLinkIcon: $this->minusLinkIcon;
        $action = $plusMinus > 0 ? '/ticket/plus/' : '/ticket/minus/';

        return '<a data-toggle="tooltip" title="' . \Yii::t('app', $title) . '"'
                    . ' href="' . $action . $this->owner->id . '">' . $icon
              .'</a>';

    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'validateVote',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'saveVoteChangeStatus',
        ];
    }

    /**
     * @param Event $event
     */
    public function validateVote($event)
    {
        return true; // Vote validation temporarily deactivated
        
        $currentUserId = \Yii::$app->user->identity->id;
        $decorationData = $this->getDecorationData();

        if (isset($decorationData[$currentUserId])) {
            if ($decorationData[$currentUserId] == $this->getVoteType($event)) {
                $event->sender->addError($this->voteAttribute, \Yii::t('app', 'Only one vote allowed per user'));
            }
        }
    }

    /**
     * @param Event $event
     */
    public function saveVoteChangeStatus($event)
    {
        if ($event->sender->isAttributeChanged($this->voteAttribute, false)) {

            $currentUserId = \Yii::$app->user->identity->id;
            $decorationData = $this->getDecorationData();

            // because of the validatio there are only two possibilities
            // the user is reversing the previous vote or
            // they are starting from an unvoted status
            if (isset($decorationData[$currentUserId])) {

                // previous vote is being reversed, allow both votes
                unset($decorationData[$currentUserId]);

            } else {

                // previously no vote, add this change
                $decorationData[$currentUserId] = $this->getVoteType($event);
            }

            $this->setDecorationData($decorationData);
        }
    }

    protected function getVoteType($event) {
        $oldVote = $event->sender->oldAttributes[$this->voteAttribute] ? $event->sender->oldAttributes[$this->voteAttribute] : 0;
        $newVote = $event->sender->attributes[$this->voteAttribute] ? $event->sender->attributes[$this->voteAttribute] : 0;

        return $oldVote < $newVote ? 1 : -1;
    }
}