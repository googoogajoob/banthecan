<?php

use frontend\models\User;

/* @var $this yii\web\View */
/* @var $userId int */

?>
<img src="<?php echo User::getAvatarUrl($userId); ?>"
	onmouseover="this.src='<?php echo User::getAvatarUrl($userId, false); ?>'"
	onmouseout="this.src='<?php echo User::getAvatarUrl($userId); ?>'" />
