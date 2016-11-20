<?php

namespace common\models\ticketDecoration;

use yii;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 8/29/15
 * Time: 12:33 AM
 */

class Link extends AbstractDecoration {

	public $linkIcon = 'L';

	/*##################*/
	/*### VIEW STUFF ###*/
	/*##################*/

	/**
	 * Render the Link Ticket Decoration
	 *
	 * @return string html for showing the ticketDecoration
	 */
	public function render() {
		return Yii::$app->getView()->render($this->renderView, [
                'decoration' => $this,
            ]
        );
    }

}