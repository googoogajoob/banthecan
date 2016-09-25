<?php

use yii\bootstrap\Modal;

Modal::begin([
    'id' => 'global-modal-container',
    'size' => 'modal-lg',
    'closeButton' => [
        'class' => 'btn btn-danger pull-right glyphicon glyphicon-remove',
        'label' => '',
    ]
    //'header' => '<h2>Global Modal Container - Header</h2>',
    //'footer' => '<em>Global Modal Container - Footer</em>'
]);
Modal::end();

?>
