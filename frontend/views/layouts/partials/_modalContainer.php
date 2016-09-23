<?php

use yii\bootstrap\Modal;

    Modal::begin([
        'header' => '<h2>' . \Yii::t('app', 'Create Ticket') . '</h2>',
        'id' => 'create-ticket-modal',
        'closeButton' => [],
        //'toggleButton' => ['label' => 'click me'],
        'size' => 'modal-lg',
        //'aria-labelledby' => 'LedBetter'
    ]);
    //echo '<div id="create-ticket-modal-content"></div>';
    Modal::end();
?>
