<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package accesspress_parallax
 */
if (!is_active_sidebar('sidebar')) {
    return;
}
?>

<div id="secondary" class="sidebar">
    <?php dynamic_sidebar('sidebar'); ?>
</div><!-- #secondary -->