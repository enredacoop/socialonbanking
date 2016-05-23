<?php
$output = $el_class = '';
extract(shortcode_atts(array(
	'el_class' => '',
	'type' => '',
	'bg_color' => '',
	'bg_image' => '',
	'bg_position' => '',
	'bg_repeat' => '',
	'bg_cover' => '0',
	'bg_attachment' => 'false',
	'padding_top' => '',
	'padding_bottom' => '',
	'margin_top' => '',
	'margin_bottom' => '',
	'animation' => '',
	'parallax_speed' => '',
	'enable_parallax' => ''
), $atts));

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.get_row_css_class().$el_class, $this->settings['base']);

if ( $type ) {

	$bg_cover = apply_filters( 'dt_sanitize_flag', $bg_cover );
	$bg_attachment = in_array( $bg_attachment, array( 'false', 'fixed', 'true' ) ) ? $bg_attachment : 'false';

	$style = array();

	if ( $bg_color ) {
		$style[] = 'background-color: ' . $bg_color;
	}

	if ( $bg_image && !in_array( $bg_image, array('none') ) ) {
		$style[] = 'background-image: url(' . esc_url($bg_image) . ')';
	}

	if ( $bg_position ) {
		$style[] = 'background-position: ' . $bg_position;
	}

	if ( $bg_repeat ) {
		$style[] = 'background-repeat: ' . $bg_repeat;
	}

	if ( 'false' != $bg_attachment ) {
		$style[] = 'background-attachment: fixed';
	} else {
		$style[] = 'background-attachment: scroll';
	}

	if ( $bg_cover ) {
		$style[] = 'background-size: cover';
	} else {
		$style[] = 'background-size: auto';
	}

	if ( $padding_top ) {
		$style[] = 'padding-top: ' . intval($padding_top) . 'px';
	}

	if ( $padding_bottom ) {
		$style[] = 'padding-bottom: ' . intval($padding_bottom) . 'px';
	}

	if ( $margin_top ) {
		$style[] = 'margin-top: ' . intval($margin_top) . 'px';
	}

	if ( $margin_bottom ) {
		$style[] = 'margin-bottom: ' . intval($margin_bottom) . 'px';
	}

	// ninjaaaa!
	$style = implode(';', $style);

	$stripe_classes = array( 'stripe' );
	$stripe_classes[] = 'stripe-style-' . esc_attr($type);


	if ( $style ) {
		$style = wp_kses( $style, array() );
		$style = ' style="' . esc_attr($style) . '"';
	}

	$data_attr = '';
	if ( '' != $parallax_speed && $enable_parallax ) {

		$parallax_speed = floatval($parallax_speed);
		if ( false == $parallax_speed ) {
			$parallax_speed = 0.1;
		}

		$stripe_classes[] = 'stripe-parallax-bg';
		$data_attr = ' data-prlx-speed="' . $parallax_speed . '"';
	}

	$output .= '<div class="' . esc_attr(implode(' ', $stripe_classes)) . '"' . $data_attr . $style . '>';
}

if ( $animation ) {
	$css_class .= " {$animation} animate-element";
}

$output .= '<div class="'.$css_class.'">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>'.$this->endBlockComment('row');

if ( $type ) {
	$output .= '</div>';
}

echo $output;