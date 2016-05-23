<?php 

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }


// ! Removing unwanted shortcodes
vc_remove_element("vc_widget_sidebar");
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_gallery");
vc_remove_element("vc_teaser_grid");
vc_remove_element("vc_button");
vc_remove_element("vc_cta_button");


// ! Changing rows and columns classes
function custom_css_classes_for_vc_row_and_vc_column($class_string, $tag) {
	if ($tag=='vc_row' || $tag=='vc_row_inner') {
		$class_string = str_replace('vc_row-fluid', 'wf-container', $class_string);
	}

	if ($tag=='vc_column' || $tag=='vc_column_inner') {
		$class_string = preg_replace('/vc_span(\d{1,2})/', 'wf-cell wf-span-$1', $class_string);
	}

	return $class_string;
}
add_filter('vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2);


// ! Adding our classes to paint standard VC shortcodes
function custom_css_accordion($class_string, $tag) {
	if ( in_array( $tag, array('vc_accordion', 'vc_toggle', 'vc_progress_bar', 'vc_posts_slider') ) ) {
		$class_string .= ' dt-style';
	}

	return $class_string;
}
add_filter('vc_shortcodes_css_class', 'custom_css_accordion', 10, 2);


// ! Adding stripes to rows
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Row style"),
	"admin_label" => true,
	"param_name" => "type",
	"value" => array(
		"Default" => "",
		"Stripe 1" => "1",
		"Stripe 2" => "2",
		"Stripe 3" => "3",
		"Stripe 4" => "4",
		"Stripe 5" => "5"
	),
	"description" => __("")
));
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => __("Background color"),
	"param_name" => "bg_color",
	"value" => "",
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "textfield", //attach_images
	//"holder" => "img",
	"class" => "dt_image",
	"heading" => __("Background image"),
	"param_name" => "bg_image",
	"description" => __("Image URL."),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Background position"),
	"param_name" => "bg_position",
	"value" => array(
		"Top" => "top",
		"Middle" => "center",
		"Bottom" => "bottom"
	),
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Background repeat"),
	"param_name" => "bg_repeat",
	"value" => array(
		"No repeat" => "no-repeat",
		"Repeat (horizontally & vertically)" => "repeat",
		"Repeat horizontally" => "repeat-x",
		"Repeat vertically" => "repeat-y"
	),
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Full-width background"),
	"param_name" => "bg_cover",
	"value" => array(
		"Disabled" => "false",
		"Enabled" => "true"
	),
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Fixed background"),
	"param_name" => "bg_attachment",
	"value" => array(
		"Disabled" => "false",
		"Enabled" => "true"
	),
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Top padding"),
	"param_name" => "padding_top",
	"value" => "40",
	"description" => __("In pixels."),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Bottom padding"),
	"param_name" => "padding_bottom",
	"value" => "40",
	"description" => __("In pixels."),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Top margin"),
	"param_name" => "margin_top",
	"value" => "40",
	"description" => __("In pixels; negative values are allowed."),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Bottom margin"),
	"param_name" => "margin_bottom",
	"value" => "40",
	"description" => __("In pixels; negative values are allowed."),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Animation"),
	"admin_label" => true,
	"param_name" => "animation",
	"value" => array(
		"None" => "",
		"Left" => "right-to-left",
		"Right" => "left-to-right",
		"Top" => "bottom-to-top",
		"Bottom" => "top-to-bottom",
		"Scale" => "scale-up",
		"Fade" => "fade-in"
	),
	"description" => __("")
));

// parallax speed
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Enable parallax"),
	"param_name" => "enable_parallax",
	"value" => array(
		"" => "false"
	),
	// "description" => __("If selected, larger image will be opened on click."),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Parallax speed"),
	"param_name" => "parallax_speed",
	"value" => "0.1",
	// "description" => __("In pixels."),
	"dependency" => array(
		"element" => "enable_parallax",
		"not_empty" => true
	)
));

// ! Adding animation to columns
vc_add_param("vc_column", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Animation"),
	"admin_label" => true,
	"param_name" => "animation",
	"value" => array(
		"None" => "",
		"Left" => "right-to-left",
		"Right" => "left-to-right",
		"Top" => "bottom-to-top",
		"Bottom" => "top-to-bottom",
		"Scale" => "scale-up",
		"Fade" => "fade-in"
	),
	"description" => __("")
));

// ! Adding tabs & tour style selector
vc_add_param("vc_tabs", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Style"),
	//"admin_label" => true,
	"param_name" => "style",
	"value" => array(
		"With backgrounds" => "tab-style-one",
		"With outlines" => "tab-style-two",
		"Backgrounds under tabs" => "tab-style-three"
	),
	"description" => __("")
));
vc_add_param("vc_tour", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Style"),
	//"admin_label" => true,
	"param_name" => "style",
	"value" => array(
		"With backgrounds" => "tab-style-one",
		"With outlines" => "tab-style-two",
		"Backgrounds under titles" => "tab-style-three"
	),
	"description" => __("")
));

// Adding stripes to inner rows
/*
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Row style"),
	"admin_label" => true,
	"param_name" => "type",
	"value" => array(
		"Default" => "",
		"Benefits container" => "benefits",
	),
	"description" => __("")
));
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Benefits style"),
	"param_name" => "style",
	"value" => array(
		"Image, title & content centered" => "1",
		"Image & title inline" => "2",
		"Image on the left" => "3"
	),
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Benefits style"),
	"param_name" => "style",
	"value" => array(
		"Image, title & content centered" => "1",
		"Image & title inline" => "2",
		"Image on the left" => "3"
	),
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Dividers"),
	"param_name" => "dividers",
	"value" => array(
		"Show" => "true",
		"Hide" => "false"
	),
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Image backgrounds"),
	"param_name" => "image_background",
	"value" => array(
		"Show" => "true",
		"Hide" => "false"
	),
	"description" => __(""),
	"dependency" => array(
		"element" => "type",
		"not_empty" => true
	)
));
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Animation"),
	"admin_label" => true,
	"param_name" => "animation",
	"value" => array(
		"None" => "",
		"Left" => "right-to-left",
		"Right" => "left-to-right",
		"Top" => "bottom-to-top",
		"Bottom" => "top-to-bottom",
		"Scale" => "scale-up",
		"Fade" => "fade-in"
	),
	"description" => __("")
));
*/


// ! Fancy Quote
vc_map( array(
	"name" => __("Fancy Quote"),
	"base" => "dt_quote",
	"icon" => "dt_vc_ico_quote",
	"class" => "dt_vc_sc_quote",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content"),
			"param_name" => "content",
			"value" => __("<p>I am test text for QUOTE. Click edit button to change this text.</p>"),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Quote type"),
			"param_name" => "type",
			"value" => array(
				"Blockquote" => "blockquote",
				"Pullquote" => "pullquote"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Font size"),
			"param_name" => "font_size",
			"value" => array(
				"Normal" => "normal",
				"Small" => "small",
				"Big" => "big"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Background & Border"),
			"param_name" => "background",
			"value" => array(
				"Border enabled, no background" => "plain",
				"Border & background enabled" => "fancy"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"param_name" => "animation",
			"value" => array(
				"None" => "none",
				"Left" => "left",
				"Right" => "right",
				"Top" => "top",
				"Bottom" => "bottom",
				"Scale" => "scale",
				"Fade" => "fade"
			),
			"description" => __("")
		)
	)
) );

// ! Call to Action
vc_map( array(
	"name" => __("Call to Action"),
	"base" => "dt_call_to_action",
	"icon" => ".dt_vc_ico_call_to_action",
	"class" => "dt_vc_sc_call_to_action",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content"),
			"param_name" => "content",
			"value" => __("<p>I am test text for CALL TO ACTION. Click edit button to change this text.</p>"),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Font size"),
			"param_name" => "content_size",
			"value" => array(
				"Normal" => "normal",
				"Small" => "small",
				"Big" => "big"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Text align"),
			"param_name" => "text_align",
			"value" => array(
				"Left" => "left",
				"Center" => "center"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Background & Border"),
			"param_name" => "background",
			"value" => array(
				"None" => "no",
				"Border enabled, no background" => "plain",
				"Border & background enabled" => "fancy"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Color accent"),
			"param_name" => "line",
			"value" => array(
				"Disable" => "false",
				"Enable" => "true"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button alignment"),
			"param_name" => "style",
			"value" => array(
				"Default" => "0",
				"On the right" => "1",
				"Center after the text" => "2"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"param_name" => "animation",
			"value" => array(
				"None" => "none",
				"Left" => "left",
				"Right" => "right",
				"Top" => "top",
				"Bottom" => "bottom",
				"Scale" => "scale",
				"Fade" => "fade"
			),
			"description" => __("")
		)
	)
) );

// ! Teaser
vc_map( array(
	"name" => __("Teaser"),
	"base" => "dt_teaser",
	"icon" => "dt_vc_ico_teaser",
	"class" => "dt_vc_sc_teaser",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type"),
			"param_name" => "type",
			"value" => array(
				"Image" => "image",
				"Video" => "video"
			),
			"description" => __("")
		),
		//Only for "image"
		array(
			"type" => "textfield",
			"holder" => "img",
			"class" => "dt_image",
			"heading" => __("Image URL"),
			"param_name" => "image",
			"value" => "",
			"description" => __(""),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"image"
				)
			)
		),
		//Only for "image"
		array(
			"type" => "textfield",
			"holder" => "img",
			"class" => "dt_image",
			"heading" => __("Image ALT"),
			"param_name" => "image_alt",
			"value" => "",
			"description" => __(""),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"image"
				)
			)
		),
		//Only for "image"
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Open in lighbox"),
			"param_name" => "lightbox",
			"value" => array(
				"" => "true"
			),
			"description" => __("If selected, larger image will be opened on click."),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"image"
				)
			)
		),
		//Only for "video"
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Video URL"),
			"admin_label" => true,
			"param_name" => "media",
			"value" => "",
			"description" => __(""),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"video"
				)
			)
		),


		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content"),
			"param_name" => "content",
			"value" => __("<p>I am test text for TEASER. Click edit button to change this text.</p>"),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Media style"),
			"param_name" => "style",
			"value" => array(
				"Full-width" => "1",
				"With paddings" => "2"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Font size"),
			"param_name" => "content_size",
			"value" => array(
				"Normal" => "normal",
				"Small" => "small",
				"Big" => "big"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Text align"),
			"param_name" => "text_align",
			"value" => array(
				"Left" => "left",
				"Center" => "center"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Background & Border"),
			"param_name" => "background",
			"value" => array(
				"None" => "no",
				"Border enabled, no background" => "plain",
				"Border & background enabled" => "fancy"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"param_name" => "animation",
			"value" => array(
				"None" => "none",
				"Left" => "left",
				"Right" => "right",
				"Top" => "top",
				"Bottom" => "bottom",
				"Scale" => "scale",
				"Fade" => "fade"
			),
			"description" => __("")
		)
	)
) );

// ! Banner
vc_map( array(
	"name" => __("Banner"),
	"base" => "dt_banner",
	"icon" => "dt_vc_ico_banner",
	"class" => "dt_vc_sc_banner",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "textfield", //attach_images
			"holder" => "img",
			"class" => "dt_image",
			"heading" => __("Background image"),
			"param_name" => "bg_image",
			"description" => __("Image URL.")
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content"),
			"param_name" => "content",
			"value" => __("<p>I am test text for BANNER. Click edit button to change this text.</p>"),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"admin_label" => true,
			"heading" => __("Banner link"),
			"param_name" => "link",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Open link in"),
			"param_name" => "target_blank",
			"value" => array(
				"Same window" => "false",
				"New window" => "true"
			),
			"description" => __(""),
			"dependency" => array(
				"element" => "link",
				"not_empty" => true
			)
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background color"),
			"param_name" => "bg_color",
			"value" => "#000000",
			"description" => __("")
		),
		array(
			"type" => "textfield", //attach_images
			"class" => "",
			"heading" => __("Background opacity"),
			"param_name" => "bg_opacity",
			"value" => "50",
			"description" => __("Percentage (from 0 to 100).")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Text color"),
			"param_name" => "text_color",
			"value" => "#ffffff",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Font size"),
			"param_name" => "text_size",
			"value" => array(
				"Normal" => "normal",
				"Small" => "small",
				"Big" => "big"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Border width"),
			"param_name" => "border_width",
			"value" => "3",
			"description" => __("In pixels.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Outer padding"),
			"param_name" => "outer_padding",
			"value" => "10",
			"description" => __("In pixels.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Inner padding"),
			"param_name" => "inner_padding",
			"value" => "10",
			"description" => __("In pixels.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Banner minimal height"),
			"param_name" => "min_height",
			"value" => "150",
			"description" => __("In pixels.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"param_name" => "animation",
			"value" => array(
				"None" => "none",
				"Left" => "left",
				"Right" => "right",
				"Top" => "top",
				"Bottom" => "bottom",
				"Scale" => "scale",
				"Fade" => "fade"
			),
			"description" => __("")
		)
	)
) );

// ! Contact form
vc_map( array(
	"name" => __("Contact Form"),
	"base" => "dt_contact_form",
	"icon" => "dt_vc_ico_contact_form",
	"class" => "dt_vc_sc_contact_form",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Form fields"),
			"admin_label" => true,
			"param_name" => "fields",
			"value" => array(
				"name" => "name",
				"email" => "email",
				"telephone" => "telephone",
				"country" => "country",
				"city" => "city",
				"company" => "company",
				"message" => "message"
			),
			"description" => __("Attention! At least one must be selected.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Message textarea height"),
			"param_name" => "message_height",
			"value" => "6",
			"description" => __("Number of lines."),
			"dependency" => array(
				"element" => "fields",
				"value" => array(
					"message"
				)
			)
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Required fields"),
			//"admin_label" => true,
			"param_name" => "required",
			"value" => array(
				"name" => "name",
				"email" => "email",
				"telephone" => "telephone",
				"country" => "country",
				"city" => "city",
				"company" => "company",
				"message" => "message"
			),
			"description" => __("Attention! At least one must be selected.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Submit button caption'),
			"param_name" => "button_title",
			"value" => "Send message",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Submit button size"),
			"param_name" => "button_size",
			"value" => array(
				"Small" => "small",
				"Medium" => "medium",
				"Big" => "big"
			),
			"description" => __("")
		)
	)
) );

// ! Map
vc_map( array(
	"name" => __("Map"),
	"base" => "dt_map",
	"icon" => "dt_vc_ico_map",
	"class" => "dt_vc_sc_map",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"admin_label" => true,
			"heading" => __("Map URL"),
			"param_name" => "src"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Map height"),
			"param_name" => "height",
			"value" => "300",
			"description" => __("In pixels")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Top margin"),
			"param_name" => "margin_top",
			"value" => "40",
			"description" => __("In pixels; negative values are allowed.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Bottom margin"),
			"param_name" => "margin_bottom",
			"value" => "40",
			"description" => __("In pixels; negative values are allowed.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Map width"),
			"param_name" => "fullwidth",
			"value" => array(
				"Normal" => "false",
				"Window-width" => "true",
			),
			"description" => __("")
		)
	)
) );

// ! Mini Blog
vc_map( array(
	"name" => __("Mini Blog"),
	"base" => "dt_blog_posts_small",
	"icon" => "dt_vc_ico_blog_posts_small",
	"class" => "dt_vc_sc_blog_posts_small",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "category",
			"class" => "",
			"heading" => __("Categories"),
			"admin_label" => true,
			"param_name" => "category",
			"description" => __("Note: By default, all your posts will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Layout"),
			"param_name" => "columns",
			"value" => array(
				"List" => "1",
				"2 columns" => "2",
				"3 columns" => "3"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Featured images"),
			"param_name" => "featured_images",
			"value" => array(
				"Show" => "true",
				"Hide" => "false"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of posts to show"),
			"param_name" => "number",
			"value" => "6",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by"),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id"
			),
			"description" => __("Select how to sort retrieved posts.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way"),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.")
		)
	)
) );

// ! Blog
vc_map( array(
	"name" => __("Blog"),
	"base" => "dt_blog_posts",
	"icon" => "dt_vc_ico_blog_posts",
	"class" => "dt_vc_sc_blog_posts",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "category",
			"class" => "",
			"admin_label" => true,
			"heading" => __("Categories"),
			"param_name" => "category",
			"description" => __("Note: By default, all your posts will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Appearance"),
			"param_name" => "type",
			"value" => array(
				"Masonry" => "masonry",
				"Grid" => "grid"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Layout"),
			"param_name" => "columns",
			"value" => array(
				"2 columns" => "2",
				"3 columns" => "3",
				"4 columns" => "4"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Thumbnails proportions"),
			"param_name" => "proportion",
			"value" => "",
			"description" => __("Width:height (e.g. 16:9). Leave this field empty to preserve original image proportions.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Posts width"),
			"param_name" => "same_width",
			"value" => array(
				"Preserve original width" => "false",
				"Make posts same width" => "true",
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of posts to show"),
			"param_name" => "number",
			"value" => "12",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by"),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id"
			),
			"description" => __("Select how to sort retrieved posts.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way"),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.")
		)
	)
) );

// ! Portfolio Scroller
vc_map( array(
	"name" => __("Portfolio Scroller"),
	"base" => "dt_portfolio_slider",
	"icon" => "dt_vc_ico_portfolio_slider",
	"class" => "dt_vc_sc_portfolio_slider",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_portfolio_category",
			"class" => "",
			"admin_label" => true,
			"heading" => __("Categories"),
			"param_name" => "category",
			"description" => __("Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Thumbnails height"),
			"param_name" => "height",
			"value" => "210",
			"description" => __("In pixels.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Thumbnails width"),
			"param_name" => "width",
			"value" => "",
			"description" => __("In pixels. Leave this field empty if you want to preserve original thumbnails proportions.")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide title"),
			"param_name" => "show_title",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide meta info"),
			"param_name" => "meta_info",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide excerpt"),
			"param_name" => "show_excerpt",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide details button"),
			"param_name" => "show_details",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide link"),
			"param_name" => "show_link",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Top margin"),
			"param_name" => "margin_top",
			"value" => "10",
			"description" => __("In pixels; negative values are allowed.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Bottom margin"),
			"param_name" => "margin_bottom",
			"value" => "10",
			"description" => __("In pixels; negative values are allowed.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of posts to show"),
			"param_name" => "number",
			"value" => "12",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by"),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id"
			),
			"description" => __("Select how to sort retrieved posts.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way"),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.")
		)
	)
) );

// ! Portfolio
vc_map( array(
	"name" => __("Portfolio"),
	"base" => "dt_portfolio",
	"icon" => "dt_vc_ico_portfolio",
	"class" => "dt_vc_sc_portfolio",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_portfolio_category",
			"class" => "",
			"heading" => __("Categories"),
			"admin_label" => true,
			"param_name" => "category",
			"description" => __("Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Appearance"),
			"param_name" => "type",
			"value" => array(
				"Masonry" => "masonry",
				"Grid" => "grid"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Layout"),
			"param_name" => "columns",
			"value" => array(
				"2 columns" => "2",
				"3 columns" => "3",
				"4 columns" => "4"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Thumbnails proportions"),
			"param_name" => "proportion",
			"value" => "",
			"description" => __("Width:height (e.g. 16:9). Leave this field empty to preserve original image proportions.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Projects width"),
			"param_name" => "same_width",
			"value" => array(
				"Preserve original width" => "false",
				"Make projects same width" => "true",
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show projects descriptions"),
			"param_name" => "descriptions",
			"value" => array(
				"Under image" => "under_image",
				"On hover" => "on_hover"
			),
			"description" => __("")
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide title"),
			"param_name" => "show_title",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide meta info"),
			"param_name" => "meta_info",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide excerpt"),
			"param_name" => "show_excerpt",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide details button"),
			"param_name" => "show_details",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Hide link"),
			"param_name" => "show_link",
			"value" => array(
				"" => "false",
			),
			"description" => __("")
		),

		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of projects to show"),
			"param_name" => "number",
			"value" => "12",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by"),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id"
			),
			"description" => __("Select how to sort retrieved posts.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way"),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.")
		)
	)
) );

// ! Photos Scroller
vc_map( array(
	"name" => __("Photos Scroller"),
	"base" => "dt_small_photos",
	"icon" => "dt_vc_ico_small_photos",
	"class" => "dt_vc_sc_small_photos",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_gallery_category",
			"class" => "",
			"admin_label" => true,
			"heading" => __("Categories"),
			"param_name" => "category",
			"description" => __("Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Open in lighbox"),
			"param_name" => "lightbox",
			"value" => array(
				"" => "true"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Thumbnails height"),
			"param_name" => "height",
			"value" => "210",
			"description" => __("In pixels.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Thumbnails width"),
			"param_name" => "width",
			"value" => "",
			"description" => __("In pixels. Leave this field empty if you want to preserve original thumbnails proportions.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Top margin"),
			"param_name" => "margin_top",
			"value" => "10",
			"description" => __("In pixels; negative values are allowed.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Bottom margin"),
			"param_name" => "margin_bottom",
			"value" => "10",
			"description" => __("In pixels; negative values are allowed.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of posts to show"),
			"param_name" => "number",
			"value" => "12",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show"),
			"param_name" => "orderby",
			"value" => array(
				"Recent photos" => "recent",
				"Random photos" => "random"
			),
			"description" => __("")
		)
	)
) );

// ! Royal Slider
vc_map( array(
	"name" => __("Royal Slider"),
	"base" => "dt_slideshow",
	"icon" => "dt_vc_ico_slideshow",
	"class" => "dt_vc_sc_slideshow",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_posttype",
			"posttype" => "dt_slideshow",
			"class" => "",
			"heading" => __("Display slideshow(s)"),
			"admin_label" => true,
			"param_name" => "posts",
			"description" => __("Attention: Do not ignore this setting! Otherwise only one (newest) slideshow will be displayed.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Width"),
			"param_name" => "width",
			"value" => "800",
			"description" => __("In pixels.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Height"),
			"param_name" => "height",
			"value" => "450",
			"description" => __("In pixels.")
		)
	)
) );

// ! Team
vc_map( array(
	"name" => __("Team"),
	"base" => "dt_team",
	"icon" => "dt_vc_ico_team",
	"class" => "dt_vc_sc_team",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_team_category",
			"class" => "",
			"heading" => __("Categories"),
			"admin_label" => true,
			"param_name" => "category",
			"description" => __("Note: By default, all your team will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Appearance"),
			"param_name" => "type",
			"value" => array(
				"Masonry" => "masonry",
				"Grid" => "grid"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Layout"),
			"param_name" => "columns",
			"value" => array(
				"2 columns" => "2",
				"3 columns" => "3",
				"4 columns" => "4"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of team members to show"),
			"param_name" => "number",
			"value" => "12",
			"description" => __("(Integer)")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by"),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id"
			),
			"description" => __("Select how to sort retrieved posts.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way"),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.")
		)
	)
) );

// ! Logotypes
vc_map( array(
	"name" => __("Logotypes"),
	"base" => "dt_logos",
	"icon" => "dt_vc_ico_logos",
	"class" => "dt_vc_sc_logos",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_logos_category",
			"class" => "",
			"admin_label" => true,
			"heading" => __("Categories"),
			"param_name" => "category",
			"description" => __("Note: By default, all your logotypes will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Layout"),
			"param_name" => "columns",
			"value" => array(
				"2 columns" => "2",
				"3 columns" => "3",
				"4 columns" => "4",
				"5 columns" => "5"
			),
			"description" => __("Note that this shortcode adapts to its holder width. Therefore real number of columns may wary from selected above.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Diveders"),
			"param_name" => "dividers",
			"value" => array(
				"Show dividers" => "true",
				"Hide dividers between logotypes" => "false"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of logotypes to show"),
			"param_name" => "number",
			"value" => "12",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by"),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id"
			),
			"description" => __("Select how to sort retrieved posts.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way"),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"param_name" => "animation",
			"value" => array(
				"None" => "none",
				"Left" => "left",
				"Right" => "right",
				"Top" => "top",
				"Bottom" => "bottom",
				"Scale" => "scale",
				"Fade" => "fade"
			),
			"description" => __("")
		)
	)
) );

// ! Testimonials
vc_map( array(
	"name" => __("Testimonials"),
	"base" => "dt_testimonials",
	"icon" => "dt_vc_ico_testimonials",
	"class" => "dt_vc_sc_testimonials",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_testimonials_category",
			"class" => "",
			"heading" => __("Categories"),
			"param_name" => "category",
			"admin_label" => true,
			"description" => __("Note: By default, all your testimonials will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Appearance"),
			"admin_label" => true,
			"param_name" => "type",
			"value" => array(
				"Slider" => "slider",
				"Masonry" => "masonry",
				"List" => "list"
			),
			"description" => __("")
		),
		//Only for masonry
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Layout"),
			"param_name" => "columns",
			"value" => array(
				"2 columns" => "2",
				"3 columns" => "3",
				"4 columns" => "4"
			),
			"description" => __('This field works only when "Appearance: Masonry" selected.'),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"masonry"
				)
			)
		),
		//Only for list
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Autoslide"),
			"param_name" => "autoslide",
			"value" => "",
			"description" => __('In milliseconds (e.g. 3 secund = 3000 miliseconds). Leave this field empty to disable autoslide. This field works only when "Appearance: Slider" selected.'),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"slider"
				)
			)
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of testimonials to show"),
			"param_name" => "number",
			"value" => "12",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by"),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id"
			),
			"description" => __("Select how to sort retrieved posts.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way"),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.")
		)
	)
) );

// ! Gap
vc_map( array(
	"name" => __("Gap"),
	"base" => "dt_gap",
	"icon" => "dt_vc_ico_gap",
	"class" => "dt_vc_sc_gap",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Gap height"),
			"admin_label" => true,
			"param_name" => "height",
			"value" => "10",
			"description" => __("In pixels.")
		)
	)
) );

// ! Divider
vc_map( array(
	"name" => __("Divider"),
	"base" => "dt_divider",
	"icon" => "dt_vc_ico_divider",
	"class" => "dt_vc_sc_divider",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Divider style"),
			"admin_label" => true,
			"param_name" => "style",
			"value" => array(
				"Thin" => "thin",
				"Thick" => "thick"
			),
			"description" => __("")
		)
	)
) );

// ! Fancy Media
vc_map( array(
	"name" => __("Fancy Media"),
	"base" => "dt_fancy_image",
	"icon" => "dt_vc_ico_fancy_image",
	"class" => "dt_vc_sc_fancy_image",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type"),
			"param_name" => "type",
			"value" => array(
				"Image" => "image",
				"Video" => "video"
			),
			"description" => __("")
		),
		//Only for "image"
		array(
			"type" => "textfield",
			"holder" => "img",
			"class" => "dt_image",
			"heading" => __("Image URL"),
			"param_name" => "image",
			"value" => "",
			"description" => __(""),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"image"
				)
			)
		),
		//Only for "image"
		array(
			"type" => "textfield",
			"holder" => "img",
			"class" => "dt_image",
			"heading" => __("Image ALT"),
			"param_name" => "image_alt",
			"value" => "",
			"description" => __(""),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"image"
				)
			)
		),
		//Only for "image"
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Open in lighbox"),
			"param_name" => "lightbox",
			"value" => array(
				"" => "true"
			),
			"description" => __("If selected, larger image will be opened on click."),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"image"
				)
			)
		),
		//Only for "video"
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Video URL"),
			"admin_label" => true,
			"param_name" => "media",
			"value" => "",
			"description" => __(""),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"video"
				)
			)
		),
/*
		array(
			"type" => "textarea_html",
			//"holder" => "div",
			"admin_label" => true,
			"class" => "",
			"heading" => __("Caption"),
			"param_name" => "content",
			//"value" => __("<p>I am test text for CAPTION. Click edit button to change this text.</p>"),
			"description" => __("")
		),
*/
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style"),
			"param_name" => "style",
			"value" => array(
				"Full-width media" => "1",
				"Media with padding" => "2",
				"Media with padding & background fill" => "3"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Width"),
			"param_name" => "width",
			"value" => "270",
			"description" => __("In pixels. Proportional height will be calculated automatically.")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Padding"),
			"param_name" => "padding",
			"value" => "10",
			"description" => __("In pixels.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Align"),
			"param_name" => "align",
			"value" => array(
				"Left" => "left",
				"Center" => "center",
				"Right" => "right"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"param_name" => "animation",
			"value" => array(
				"None" => "none",
				"Left" => "left",
				"Right" => "right",
				"Top" => "top",
				"Bottom" => "bottom",
				"Scale" => "scale",
				"Fade" => "fade"
			),
			"description" => __("")
		)
	)
) );

// ! Button
vc_map( array(
	"name" => __("Button"),
	"base" => "dt_button",
	"icon" => "dt_vc_ico_button",
	"class" => "dt_vc_sc_button",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Caption"),
			"admin_label" => true,
			"param_name" => "content",
			"value" => "",
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link URL"),
			"param_name" => "link",
			"value" => "",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Open link in"),
			"param_name" => "target_blank",
			"value" => array(
				"Same window" => "false",
				"New window" => "true"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style"),
			"param_name" => "size",
			"value" => array(
				"Small button" => "small",
				"Medium button" => "medium",
				"Big button" => "big",
				"Link" => "link"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button color"),
			"param_name" => "color",
			"value" => array(
				"Accent color" => "",
				"White" => "white",
				"Red" => "red",
				"Berry" => "berry",
				"Orange" => "orange",
				"Yellow" => "yellow",
				"Pink" => "pink",
				"Green" => "green",
				"Dark_green" => "dark_green",
				"Blue" => "blue",
				"Dark_blue" => "dark_blue",
				"Violet" => "violet",
				"Black" => "black",
				"Gray" => "gray"
			),
			"description" => __(""),
			"dependency" => array(
				"element" => "size",
				"value" => array(
					"small",
					"medium",
					"big"
				)
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"param_name" => "animation",
			"value" => array(
				"None" => "none",
				"Left" => "left",
				"Right" => "right",
				"Top" => "top",
				"Bottom" => "bottom",
				"Scale" => "scale",
				"Fade" => "fade"
			),
			"description" => __("")
		)
	)
) );

// ! Fancy List
vc_map( array(
	"name" => __("Fancy List"),
	"base" => "dt_vc_list",
	"icon" => "dt_vc_ico_list",
	"class" => "dt_vc_sc_list",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Caption"),
			"param_name" => "content",
			"value" => __("<ul><li>Your list</li><li>goes</li><li>here!</li></ul>"),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("List style"),
			"param_name" => "style",
			"value" => array(
				"Unordered" => "1",
				"Ordered (numbers)" => "2",
				"No bullets" => "3"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Dividers"),
			"param_name" => "dividers",
			"value" => array(
				"Show" => "true",
				"Hide" => "false"
			),
			"description" => __("")
		)
	)
) );


// ! Benefits
vc_map( array(
	"name" => __("Benefits"),
	"base" => "dt_benefits_vc",
	"icon" => "dt_vc_ico_benefits",
	"class" => "dt_vc_sc_benefits",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_benefits_category",
			"class" => "",
			"admin_label" => true,
			"heading" => __("Categories"),
			"param_name" => "category",
			"description" => __("Note: By default, all your benefits will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Layout"),
			"param_name" => "columns",
			"value" => array(
				"2 columns" => "2",
				"3 columns" => "3",
				"4 columns" => "4",
				"5 columns" => "5"
			),
			"description" => __("Note that this shortcode adapts to its holder width. Therefore real number of columns may wary from selected above.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Benefits style"),
			"param_name" => "style",
			"value" => array(
				"Image, title & content centered" => "1",
				"Image & title inline" => "2",
				"Image on the left" => "3"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Dividers"),
			"param_name" => "dividers",
			"value" => array(
				"Show" => "true",
				"Hide" => "false"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Image backgrounds"),
			"param_name" => "image_background",
			"value" => array(
				"Show" => "true",
				"Hide" => "false"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Open link in"),
			"param_name" => "target_blank",
			"value" => array(
				"Same window" => "false",
				"New window" => "true"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Title font size"),
			"param_name" => "header_size",
			"value" => array(
				"H1" => "h1",
				"H2" => "h2",
				"H3" => "h3",
				"H4" => "h4",
				"H5" => "h5",
				"H6" => "h6"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Content font size"),
			"param_name" => "content_size",
			"value" => array(
				"Normal" => "normal",
				"Small" => "small",
				"Big" => "big"
			),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of benefits to show"),
			"param_name" => "number",
			"value" => "8",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by"),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id"
			),
			"description" => __("Select how to sort retrieved posts.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way"),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation"),
			"admin_label" => true,
			"param_name" => "animation",
			"value" => array(
				"None" => "none",
				"Left" => "left",
				"Right" => "right",
				"Top" => "top",
				"Bottom" => "bottom",
				"Scale" => "scale",
				"Fade" => "fade"
			),
			"description" => __("")
		)
	)
) );

/*
// Benefit
vc_map( array(
	"name" => __("Benefit"),
	"base" => "dt_benefit",
	"icon" => "dt_vc_ico_benefit",
	"class" => "dt_vc_sc_benefit",
	"category" => __('by Dream-Theme'),
	"params" => array(
		array(
			"type" => "textfield", //attach_images
			"holder" => "img",
			"class" => "dt_image",
			"heading" => __("Image"),
			"param_name" => "image",
			"description" => __("Image URL.")
		),
		array(
			"type" => "textfield", //attach_images
			"holder" => "img",
			"class" => "dt_image",
			"heading" => __("HD (retina) image"),
			"param_name" => "hd_image",
			"description" => __("HD (retina) image URL.")
		),
		array(
			"type" => "textfield",
			"holder" => "h4",
			"class" => "",
			"heading" => __("Title"),
			"param_name" => "title",
			"description" => __("")
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content"),
			"param_name" => "content",
			"value" => __("<p>I am test text for BENEFIT. Click edit button to change this text.</p>"),
			"description" => __("")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link URL"),
			"param_name" => "image_link",
			"value" => "",
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Open link in"),
			"param_name" => "target_blank",
			"value" => array(
				"Same window" => "false",
				"New window" => "true"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Title font size"),
			"param_name" => "header_size",
			"value" => array(
				"H1" => "h1",
				"H2" => "h2",
				"H3" => "h3",
				"H4" => "h4",
				"H5" => "h5",
				"H6" => "h6"
			),
			"description" => __("")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Content font size"),
			"param_name" => "content_size",
			"value" => array(
				"Normal" => "normal",
				"Small" => "small",
				"Big" => "big"
			),
			"description" => __("")
		)
	)
) );
*/

?>
