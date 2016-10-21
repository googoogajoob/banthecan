<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 19.10.16
 * Time: 19:44
 */

namespace apc\rewrite\bootstrap;

use Yii;
use yii\bootstrap\NavBar as BootstrapNavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class NavBar extends BootstrapNavBar
{
    /**
     * @var Array of content and options for additional header options
     *  Array of arrays with Keys: 'content', 'options'
     */
    public $additionalHeaders = [];

    public function init()
    {
        $grandfather = get_parent_class(get_parent_class($this));
        $grandfather::init();

        $this->clientOptions = false;

        if (empty($this->options['class'])) {
            Html::addCssClass($this->options, ['navbar', 'navbar-default']);
        } else {
            Html::addCssClass($this->options, ['widget' => 'navbar']);
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'nav');
        echo Html::beginTag($tag, $options);

        if ($this->renderInnerContainer) {
            if (!isset($this->innerContainerOptions['class'])) {
                Html::addCssClass($this->innerContainerOptions, 'container');
            }
            echo Html::beginTag('div', $this->innerContainerOptions);
        }

        echo Html::beginTag('div', ['class' => 'navbar-header']);

        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = "{$this->options['id']}-collapse";
        }

        echo $this->renderToggleButton();

        if ($this->brandLabel !== false) {
            Html::addCssClass($this->brandOptions, ['widget' => 'navbar-brand']);
            echo Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl, $this->brandOptions);
        }

        echo Html::endTag('div');

        $this->_additionalHeaders();

        Html::addCssClass($this->containerOptions, ['collapse' => 'collapse', 'widget' => 'navbar-collapse']);
        $options = $this->containerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::beginTag($tag, $options);
    }

    protected function _additionalHeaders()
    {
        foreach($this->additionalHeaders as $key => $value) {

            if ($value) {
                if (!isset($value['options'])) {
                    $value['options'] = null;
                }
                Html::addCssClass($value['options'], ['class' => 'navbar-header']);

                echo Html::beginTag('div', $value['options']);
                echo $value['content'];
                echo Html::endTag('div');
            }

        }
    }
}