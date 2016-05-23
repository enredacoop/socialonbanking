<?php
/*
 *	Ubermenu related actions
 **/

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// remove_action( 'presscore_primary_navigation', 'presscore_add_primary_menu', 15 );

function presscore_ubermenu_primary_menu() {
	$theme_location = 'primary';

	if ( has_nav_menu($theme_location) ) {

		$args = array(
			'theme_location' => $theme_location,
			'container' => false,
		);

		wp_nav_menu( $args );
	} else {

		presscore_add_primary_menu();
	}
}
// add_action( 'presscore_primary_navigation', 'presscore_ubermenu_primary_menu', 15 );

/**
 * Description here.
 *
 */
function presscore_ubermenu_body_class_filter( $classes = array() ) {

	if ( has_nav_menu('primary') ) {
		$classes[] = 'dt-style-um';
	}

	return $classes;
}
add_filter( 'body_class', 'presscore_ubermenu_body_class_filter' );