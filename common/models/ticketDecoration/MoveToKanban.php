<?php

namespace common\models\ticketDecoration;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/29/15
 * Time: 12:33 AM
 */

class MoveToKanban extends AbstractDecoration {

    public $linkIcon = 'K';

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
    public function show($view = 'default') {
        return '<a data-toggle="tooltip" title="Move to KanBan Board" href="/ticket/board/' . $this->owner->id . '">' . $this->linkIcon .'</a>';
    }

}