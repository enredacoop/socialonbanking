<?php
/*
 *	Woocommerce related actions
 **/

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Add actions.
 *
 */
add_action( 'after_setup_theme', 'dt_theme_add_woocommerce_support', 16 );
add_action( 'woocommerce_before_main_content', 'dt_woocommerce_before_main_content' );
add_action( 'woocommerce_after_main_content', 'dt_woocommerce_after_main_content' );

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

/**
 * Description here.
 *
 */
function dt_woocommerce_before_main_content () {
?>
	<!-- Content -->
	<div id="content" class="content" role="main">
<?php
}

/**
 * Description here.
 *
 */
function dt_woocommerce_after_main_content () {
?>
	</div>
<?php
}

/**
 * Add woocommerce support.
 *
 */
function dt_theme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/**
 * Redefine woocommerce_output_related_products().
 *
 */
function woocommerce_output_related_products() {
	woocommerce_related_products( 4, 2 ); // Display 4 products in rows of 2
}

/**
 * Remove theme title on woocommerce pages.
 *
 */
function dt_remove_theme_title() {
	if ( function_exists('is_woocommerce') && is_woocommerce() ) {
		remove_action('presscore_before_main_container', 'presscore_page_title_controller', 16);
	}
}
add_action('presscore_before_main_container', 'dt_remove_theme_title', 15);

/**
 * Load custom js.
 *
 * TODO: finish in 1.0.7
 */
function presscore_woocommerce_enqueue_scripts() {

	wp_enqueue_script( 'dt-wc-custom', PRESSCORE_URI . '/mod-woocommerce/mod-woocommerce-custom.js', array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'presscore_woocommerce_enqueue_scripts', 16 );