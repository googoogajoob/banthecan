<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 29.10.16
 * Time: 11:41
 */

    $searchPanelOpen = false;
    if (isset($_COOKIE['search-block'])) {
        $searchPanelOpen = $_COOKIE['search-block'] == '1';
    }
?>

<button
    id="show-search-option-button"
    type="button"
    class="btn btn-primary btn-xs <?php echo $searchPanelOpen ? 'hidden' : ''?>"
    data-toggle="collapse"
    data-target="#left-sidebar"
    aria-controls="left-sidebar"
    aria-expanded="<?php echo $searchPanelOpen ? 'true' : 'false'?>">
    <?php echo \Yii::t('app', 'Show Search Options'); ?>
</button>


