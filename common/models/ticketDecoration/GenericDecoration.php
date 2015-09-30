<?php

namespace common\models\ticketDecoration;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/29/15
 * Time: 12:33 AM
 */

class GenericDecoration extends AbstractDecoration {

    private $_junk = 0;

    /**
     * Performs the tasks or functions that a ticketDecoration is designed to do
     * @return boolean success or failure
     */
    public function doDecoration() {
        $this->_junk = 5;

        return true;
    }

    /**
     * Show a view of the Behavior
     * The default is the Icon Click element
     * A Decoration can have multiple views
     *
     * @return string html for showing the ticketDecoration
     */
    public function show($view = 'default') {
        return "<p>Hello World! I'm the generic Decoration. My Value is " . $this->_junk . "</p>";
    }

}