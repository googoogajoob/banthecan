<?php

use yii\bootstrap\Modal;

Modal::begin([
    'id' => 'global-modal-container',
    'size' => 'modal-lg',
    'closeButton' => [
        'class' => 'btn btn-danger pull-right glyphicon glyphicon-remove',
        'label' => '',
        'id' => 'modal-close-button',
    ],
    'options' => [
        'data-backdrop' => "false"
    ],
    'header' => '<img id="modal-ajax-loader" src="/images/ajax-loader-bar.gif" /><div id="modal-header-row" class="row"></div>',
    //'footer' => '<em>Global Modal Container - Footer</em>'
]);
Modal::end();

?>
