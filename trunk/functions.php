<?php

/**
 * Add All Scipts panle to degub bar
 * @param  array $panels 
 * @return array
 */
function ravs_debug_bar_post_meta( $panels ) {
	require_once 'inc/class-show-all-scripts.php';
	require_once 'inc/class-show-all-styles.php';
	$panels[] = new Ravs_Show_All_Scripts();
	$panels[] = new Ravs_Show_All_Styles();
	return $panels;
}
add_action('debug_bar_panels', 'ravs_debug_bar_post_meta');