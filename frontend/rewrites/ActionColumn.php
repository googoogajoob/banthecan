<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 07.01.18
 * Time: 21:38
 */

namespace frontend\rewrites;

class ActionColumn extends \yii\grid\ActionColumn
{
    protected function renderFilterCellContent()
    {
        return '<div class="task-gylphicon-clear-div">
                    <span                         
                        class="task-gylphicon-clear-icon glyphicon glyphicon-remove-circle" 
                        title="' . \Yii::t('app', 'Clear Filters') .'" 
                        onclick="cleartasksearchfields();"
                    >
                    </span>
                </div>';
    }
}