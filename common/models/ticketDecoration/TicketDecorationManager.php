<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 10/15/15
 * Time: 8:22 PM
 */

namespace common\models\ticketDecoration;

use common\models\Ticket;
use yii;
use yii\base\Object;


class TicketDecorationManager extends Object {

    public $decorationClasses;

    /**
     * Extract the specified ticket decoration class configurations specified by $classNames
     * and register them under the Alias Ticket::TICKET_DECORATION_CLASS_ALIAS in the DI-Container class
     *
     * @param null $classNames
     */
    public function registerDecorations($classNames = null) {
        if (is_array($classNames)) {

            // Start with an empty set and add the configurations that are specified
            $decorationConfigurations = ['class' => Ticket::TICKET_DECORATION_CLASS_ALIAS];
            $configurationExists = false;

            foreach ($classNames as $className) {
                if (array_key_exists($className, $this->decorationClasses)) {
                    $decorationConfigurations[] = $this->decorationClasses[$className]['class'];
                    $configurationExists = true;
                }
            }

            if ($configurationExists) {
                Yii::$container->set(Ticket::TICKET_DECORATION_CLASS_ALIAS, $decorationConfigurations);
            }
        }
    }
}