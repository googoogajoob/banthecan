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
        return '<div style="margin: 2px 0 0 15px; ">
                    <span 
                        style="font-size:200%" 
                        class="glyphicon glyphicon-remove-circle" 
                        title="Clear Search Filters" 
                        onclick="$(\'.form-control\').val(\'\');"
                    >
                    </span>
                </div>';
    }
}