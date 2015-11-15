<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BacklogAsset extends AssetBundle
{
    public $sourcePath = '@frontend/views/ticket/';
    public $css = [
        'ticket.css',
    ];
    public $js = [
        'ticketTooltip.js',
        'ticketDetailView.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset'
    ];
}
