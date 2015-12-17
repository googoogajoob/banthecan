<?php

namespace common\models\ticketDecoration;

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/29/15
 * Time: 12:33 AM
 */

class ViewTags extends AbstractDecoration
{

    public $linkIcon = 'T';

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
        if ($taglist = $this->owner->tagNames) {
            return Html::tag('span',
                '',
                [
                    'class' => 'ticket-glyph-tags glyphicon glyphicon-tags',
                    'title' => 'Tags',
                    'data-toggle' => 'popover',
                    'data-trigger' => 'hover',
                    'data-content' => Html::encode($taglist),
                ]
            );
        } else {
            return '';
        }

    }

}