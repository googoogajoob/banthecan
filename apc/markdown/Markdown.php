<?php
/**
 * @copyright Copyright (c) 2014 Carsten Brandt
 * @license https://github.com/cebe/markdown/blob/master/LICENSE
 * @link https://github.com/cebe/markdown#readme
 */

namespace apc\markdown;

use yii\helpers\Markdown as YiiMarkdown;

class Markdown extends YiiMarkdown
{
    public static $defaultFlavor = 'apc';

    /**
     * @inheritdoc
     */
    protected static function getParser($flavor)
    {
        self::$flavors['apc'] = [
            'class' => 'apc\markdown\ApcMarkdown',
            'html5' => true,
        ];

        return parent::getParser($flavor);
    }
}

