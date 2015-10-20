<?php

namespace common\models\ticketDecoration;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/29/15
 * Time: 12:33 AM
 */

class Generic extends AbstractDecoration {

    private $_junk = 0;


    /*### MODEL STUFF ###*/

    /**
     * Performs the tasks or functions that a ticketDecoration is designed to do
     * @return boolean success or failure
     */
    public function doDecoration() {
        return true;
    }

    /*### VIEW STUFF ###*/

    /**
     * Show a view of the Behavior
     * The default is the Icon Click element
     * A Decoration can have multiple views
     *
     * @return string html for showing the ticketDecoration
     */
    public function show($view = 'default') {
        $view='junk';
        return 'G';
    }

}