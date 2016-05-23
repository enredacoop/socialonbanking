<?php
/**
 * Benefits post metaboxes.
 * @since presscore 0.1
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/***********************************************************/
// Benefits options
/***********************************************************/

$prefix = '_dt_benefits_options_';

$DT_META_BOXES[] = array(
	'id'		=> 'dt_page_box-benefits_options',
	'title' 	=> _x('Options', $translation_content, LANGUAGE_ZONE),
	'pages' 	=> array( 'dt_benefits' ),
	'context' 	=> 'side',
	'priority' 	=> 'core',
	'fields' 	=> array(

		// Link
		array(
			'name'	=> _x('Target link:', $translation_content, LANGUAGE_ZONE),
			'id'    => "{$prefix}link",
			'type'  => 'text',
			'std'   => '',
		),

		// Uploader
		// IMAGE ADVANCED (WP 3.5+)
		array(
			'name'				=> _x('Retina image:', $translation_content, LANGUAGE_ZONE),
			'id'               	=> "{$prefix}retina_image",
			'type'             	=> 'image_advanced_mk2',
			'max_file_uploads' 	=> 1,
		),

	),
);