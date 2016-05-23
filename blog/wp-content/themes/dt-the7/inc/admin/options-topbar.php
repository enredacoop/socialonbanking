<?php
/**
 * Top Bar Options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Page definition.
 */
$options[] = array(
		"page_title" 	=> _x( "Top Bar", 'theme-options', LANGUAGE_ZONE ),
		"menu_title" 	=> _x( "Top Bar", 'theme-options', LANGUAGE_ZONE ),
		"menu_slug"		=> "of-topbar-menu",
		"type" 			=> "page"
);

/**
 * Heading definition.
 */
$options[] = array( "name" => _x('Top Bar', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

/**
 * Show top bar.
 */
$options[] = array(	"name" => _x('Show top bar', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	// checkbox
	$options[] = array(
		"name"  => '',
		"desc"  => _x( 'Show top bar', 'theme-options', LANGUAGE_ZONE ),
		"id"    => 'top_bar-show',
		"type"  => 'checkbox',
		'std'   => 1
	);

$options[] = array(	"type" => "block_end");

/**
 * Top bar background.
 */
$options[] = array(	"name" => _x('Top bar background', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	// colorpicker
	$options[] = array(
		"name"  => '',
		"desc"  => _x( 'Background color', 'theme-options', LANGUAGE_ZONE ),
		"id"    => "top_bar-bg_color",
		"std"   => "#ffffff",
		"type"  => "color"
	);

	// slider
	$options[] = array(
		"name"      => '',
		"desc"      => _x( 'Opacity', 'theme-options', LANGUAGE_ZONE ),
		"id"        => "top_bar-bg_opacity",
		"std"       => 100, 
		"type"      => "slider",
		"options"   => array( 'java_hide_if_not_max' => true )
	);

	// hidden area
	$options[] = array( 'type' => 'js_hide_begin' );

		// colorpicker
		$options[] = array(
			"name"  => '',
			"desc"  => _x( 'old Internet Explorer color', 'theme-options', LANGUAGE_ZONE ),
			"id"    => "top_bar-bg_ie_color",
			"std"   => "#ffffff",
			"type"  => "color"
		);

	$options[] = array( 'type' => 'js_hide_end' );

	// background_img
	$options[] = array(
		'desc'			=> _x( 'Image uploader', 'theme-options', LANGUAGE_ZONE ),
		'id' 			=> 'top_bar-bg_image',
		'preset_images' => $backgrounds_top_bar_bg_image,
		'std' 			=> array(
			'image'			=> '',
			'repeat'		=> 'repeat',
			'position_x'	=> 'center',
			'position_y'	=> 'center'
		),
		'type'			=> 'background_img'
	);

$options[] = array(	"type" => "block_end");

/**
 * Text color.
 */
$options[] = array(	"name" => _x('Text color', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	// colorpicker
	$options[] = array(
		"name"  => '',
		"desc"  => _x( 'Text Color', 'theme-options', LANGUAGE_ZONE ),
		"id"    => "top_bar-text_color",
		"std"   => "#686868",
		"type"  => "color"
	);

$options[] = array(	"type" => "block_end");

/**
 * Lines &amp; dividers.
 */
$options[] = array(	"name" => _x('Lines &amp; dividers', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	// colorpicker
	$options[] = array(
		"name"	=> '',
		"desc"	=> _x( 'Color', 'theme-options', LANGUAGE_ZONE ),
		"id"	=> "top_bar-dividers_color",
		"std"	=> "#828282",
		"type"	=> "color"
	);

	// slider
	$options[] = array(
		"name"      => '',
		"desc"      => _x( 'Opacity', 'theme-options', LANGUAGE_ZONE ),
		"id"        => "top_bar-dividers_opacity",
		"std"       => 100, 
		"type"      => "slider",
		"options"   => array( 'java_hide_if_not_max' => true )
	);

	// hidden area
	$options[] = array( 'type' => 'js_hide_begin' );

		// colorpicker
		$options[] = array(
			"name"  => '',
			"desc"  => _x( 'Internet Explorer color', 'theme-options', LANGUAGE_ZONE ),
			"id"    => "top_bar-dividers_ie_color",
			"std"   => "#828282",
			"type"  => "color"
		);

	$options[] = array( 'type' => 'js_hide_end' );

$options[] = array(	"type" => "block_end");

/**
 * Contact information.
 */
$options[] = array(	"name" => _x('Contact information', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	// checkbox
	$options[] = array(
		"name"  => '',
		"desc" 	=> _x( 'Show contact information', 'theme-options', LANGUAGE_ZONE ),
		"id"    => 'top_bar-contact_show',
		"type"  => 'checkbox',
		'std'   => 1
	);

	// contact fields
	foreach( $contact_fields as $field ) {

		$options[] = array(
			"name"      => '',
			"desc"      => $field['desc'],
			"id"        => 'top_bar-contact_' . $field['prefix'],
			"std"       => '',
			"type"      => 'text',
			"sanitize"	=> 'textarea'
		);

	} // end contact fields

$options[] = array(	"type" => "block_end");

/**
 * Text.
 */
$options[] = array(	"name" => _x('Text', 'theme-options', 'presscore'), "type" => "block_begin" );

	// textarea
	$options[] = array(
		"desc"		=> _x('Text', 'theme-options', 'presscore'),
		"id"		=> "top_bar-text",
		"std"		=> false,
		"type"		=> 'textarea'
	);

$options[] = array(	"type" => "block_end");

/**
 * Social icons.
 */
$options[] = array(	"name" => _x('Social icons', 'theme-options', 'presscore'), "type" => "block_begin" );

	// colorpicker
	$options[] = array(
		"name"	=> '',
		"desc"	=> _x( 'Color', 'theme-options', LANGUAGE_ZONE ),
		"id"	=> "top_bar-soc_icon_color",
		"std"	=> "#828282",
		"type"	=> "color"
	);

	foreach ( presscore_get_social_icons_data() as $value=>$title ) {

		// input
		$options[] = array(
			"desc"		=> $title,
			"id"		=> "top_bar-soc_ico_{$value}",
			"std"		=> '',
			"type"		=> 'text',
			"sanitize"	=> 'url'
		);

	}

$options[] = array(	"type" => "block_end");