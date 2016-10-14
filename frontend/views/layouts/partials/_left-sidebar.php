<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 11/22/15
 * Time: 7:43 PM
 */
?>

<?php
	if ($this->blocks && array_key_exists('left-sidebar', $this->blocks)) {
		echo $this->blocks['left-sidebar'];
	}
?>
