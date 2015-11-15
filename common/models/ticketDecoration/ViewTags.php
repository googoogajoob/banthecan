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
        //return '<button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-content="And here is some amazing content. It is very engaging. Right?">Click to toggle popover</button>';

        return '<span id="junk" class="glyphicon glyphicon-tags" data-toggle="popover" title="Ticket Tags" data-content="And here is some amazing content. It is very engaging. Right?"></span>';

        /*return Html::a(
            $this->linkIcon,
            '/ticket/view/' . $this->owner->id, [
                'onClick' => 'ticketDetailView(' . $this->owner->id . '); return false;',
            ]
        );*/
    }

}