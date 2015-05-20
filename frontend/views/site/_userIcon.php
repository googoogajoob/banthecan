<?php

use common\models\User;

/**
 * Created by PhpStorm.
 * User: and
 * Date: 4/2/15
 * Time: 11:40 PM
 */

/* @var $this yii\web\View */
/* @var $userId int */
?>
<img src="<?php echo User::getAvatarUrl($userId) ?>"/>