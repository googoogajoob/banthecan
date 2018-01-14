<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 07.01.18
 * Time: 21:38
 */

namespace apc\rewrite\frontend;

class ActionColumn extends \yii\grid\ActionColumn
{
    protected function renderFilterCellContent()
    {
        return '<div class="task-gylphicon-clear-div" data-pjax="0">
                    <a href="/task"><span                         
                        class="task-gylphicon-clear-icon glyphicon glyphicon-remove-circle" 
                        title="' . \Yii::t('app', 'Clear Filters') .'" 
                    >
                    </span></a>
                </div>';
    }
}