<?php
/**
 * Portfolio shortcode.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Shortcode testimonials class.
 *
 */
class DT_Shortcode_Portfolio_Slider extends DT_Shortcode {

	static protected $instance;

	protected $shortcode_name = 'dt_portfolio_slider';
	protected $post_type = 'dt_portfolio';
	protected $taxonomy = 'dt_portfolio_category';
	protected $plugin_name = 'dt_mce_plugin_shortcode_portfolio_slider';
	protected $atts;

	public static function get_instance() {
		if ( !self::$instance ) {
			self::$instance = new DT_Shortcode_Portfolio_Slider();
		}
		return self::$instance;
	}

	protected function __construct() {

		add_shortcode( $this->shortcode_name, array($this, 'shortcode') );

		// add shortcode button
		// $tinymce_button = new DT_ADD_MCE_BUTTON( $this->plugin_name, basename(dirname(__FILE__)), false, 4 );
	}

	public function shortcode( $atts, $content = null ) {
		$attributes = shortcode_atts( array(
			'category'              => '',
			'order'                 => '',
			'orderby'               => '',
			'number'                => '6',
			'show_title'            => '1',
			'show_excerpt'          => '1',
			'show_details'          => '1',
			'show_link'             => '1',
			'meta_info'             => '1',
			'width'                 => '',
			'height'                => '',
			'margin_top'            => '',
			'margin_bottom'         => '',
		), $atts );
		
		// sanitize attributes
		$attributes['order'] = apply_filters('dt_sanitize_order', $attributes['order']);
		$attributes['orderby'] = apply_filters('dt_sanitize_orderby', $attributes['orderby']);
		$attributes['number'] = apply_filters('dt_sanitize_posts_per_page', $attributes['number']);

		if ( $attributes['category']) {
			$attributes['category'] = explode(',', $attributes['category']);
			$attributes['category'] = array_map('trim', $attributes['category']);
			$attributes['select'] = 'only';
		} else {
			$attributes['select'] = 'all';
		}

		$attributes['show_title'] = apply_filters('dt_sanitize_flag', $attributes['show_title']);
		$attributes['show_excerpt'] = apply_filters('dt_sanitize_flag', $attributes['show_excerpt']);
		$attributes['show_details'] = apply_filters('dt_sanitize_flag', $attributes['show_details']);
		$attributes['show_link'] = apply_filters('dt_sanitize_flag', $attributes['show_link']);
		$attributes['meta_info'] = apply_filters('dt_sanitize_flag', $attributes['meta_info']);

		// slideshow attributes
		// for backword compatibility
		$attributes['width'] = absint($attributes['width']);
		$attributes['height'] = absint($attributes['height']);
		$attributes['margin_top'] = $attributes['margin_top'] ? intval($attributes['margin_top']) . 'px' : '';
		$attributes['margin_bottom'] = $attributes['margin_bottom'] ? intval($attributes['margin_bottom']) . 'px' : '';

		// save atts for ... what for ?
		$this->atts = $attributes;

		$output = $this->portfolio_slider($attributes);

		return $output; 
	}

	/**
	 * Portfolio slider.
	 *
	 */
	public function portfolio_slider( $attributes = array() ) {
		$config = Presscore_Config::get_instance();

		$related_posts_args = array(
			'exclude_current'   => false,
			'post_type'         => 'dt_portfolio',
			'taxonomy'          => 'dt_portfolio_category',
			'field'             => 'slug',
			'args'              => array(
				'posts_per_page'    => $attributes['number'],
				'orderby'           => $attributes['orderby'],
				'order'             => $attributes['order'],
			)
		);

		if ( !empty($attributes['category']) ) {
			$related_posts_args['cats'] = $attributes['category'];
			$related_posts_args['select'] = 'only';
		} else {
			$related_posts_args['select'] = 'all';
		}

		$attachments_data = presscore_get_related_posts( $related_posts_args );

		$slider_class = array();
		if ( 'disabled' == $config->get('sidebar_position') ) {
			$slider_class[] = 'full';
		}

		$slider_fields = array();

		if ( $attributes['show_title'] ) {
			$slider_fields[] = 'title';
		}

		if ( $attributes['meta_info'] ) {
			$slider_fields[] = 'meta';
		}

		if ( $attributes['show_excerpt'] ) {
			$slider_fields[] = 'description';
		}

		if ( $attributes['show_link'] ) {
			$slider_fields[] = 'link';
		}

		if ( $attributes['show_details'] ) {
			$slider_fields[] = 'details';
		}

		$slider_style = array();
		if ( $attributes['margin_bottom'] ) {
			$slider_style[] = 'margin-bottom: ' . $attributes['margin_bottom'];
		}

		if ( $attributes['margin_top'] ) {
			$slider_style[] = 'margin-top: ' . $attributes['margin_top'];
		}

		$slider_args = array(
			'fields'        => $slider_fields,
			'class'         => $slider_class,
			'style'         => implode(';', $slider_style)
		);

		if ( $attributes['height'] ) {
			$slider_args['height'] = $attributes['height'];
		}

		if ( $attributes['width'] ) {
			$slider_args['img_width'] = $attributes['width'];
		}

		$output = presscore_get_fullwidth_slider_two( $attachments_data, $slider_args );

		return $output;
	}

}

// create shortcode
DT_Shortcode_Portfolio_Slider::get_instance();