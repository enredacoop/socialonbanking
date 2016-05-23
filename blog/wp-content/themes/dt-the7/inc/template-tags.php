<?php
/**
 * Custom template functions for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package presscore
 * @since presscore 1.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Show content for blog'like page templates.
 *
 * Uses template settings.
 */
function presscore_page_content_controller() {
	global $post;

	// if is not page - return
	if ( !is_page() ) {
		return;
	}

	$display_content = get_post_meta( $post->ID, '_dt_content_display',  true );

	// if content hidden - return
	if ( !$display_content || 'no' == $display_content ) {
		return;
	}

	// only for first page
	if ( 'on_first_page' == $display_content && dt_get_paged_var() > 1 ) {
		return;
	}

	$content_position = get_post_meta( $post->ID, '_dt_content_position',  true );

	if ( 'before_items' == $content_position ) {

		add_action('presscore_before_loop', 'presscore_get_page_content_before', 20);
	} else {

		add_action('presscore_after_loop', 'presscore_get_page_content_after', 20);
	}
}

/**
 * Page title controller.
 */
function presscore_page_title_controller() {
	global $post;

	$before_title = '<div class="page-title">';
	$after_title = '</div>';
	$title_template = '<h1>%s</h1>';
	$title = '';
	$breadcrumbs = true;
	$is_single = is_single();

	if ( is_page() || $is_single ) {

		$title_mode = get_post_meta($post->ID, '_dt_header_title', true);

		if ( 'disabled' != $title_mode && presscore_is_content_visible() ) {

			if ( $is_single ) {
				$title_template = '<h1 class="entry-title">%s</h1>';
			}

			$title = sprintf( $title_template, apply_filters('the_title', get_the_title($post->ID)) );

		} else {
			$breadcrumbs = false;
			$before_title = $after_title = '';

		}

	} else if ( is_search() ) {
		$message = sprintf( _x( 'Search Results for: %s', 'archive template title', LANGUAGE_ZONE ), '<span>' . get_search_query() . '</span>' );
		$title = sprintf( $title_template, $message );

	} else if ( is_archive() ) {

		if ( is_category() ) {
			$message = sprintf( _x( 'Category Archives: %s', 'archive template title', LANGUAGE_ZONE ), '<span>' . single_cat_title( '', false ) . '</span>' );

		} elseif ( is_tag() ) {
			$message = sprintf( _x( 'Tag Archives: %s', 'archive template title', LANGUAGE_ZONE ), '<span>' . single_tag_title( '', false ) . '</span>' );

		} elseif ( is_author() ) {
			the_post();
			$message = sprintf( _x( 'Author Archives: %s', 'archive template title', LANGUAGE_ZONE ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
			rewind_posts();

		} elseif ( is_day() ) {
			$message = sprintf( _x( 'Daily Archives: %s', 'archive template title', LANGUAGE_ZONE ), '<span>' . get_the_date() . '</span>' );

		} elseif ( is_month() ) {
			$message = sprintf( _x( 'Monthly Archives: %s', 'archive template title', LANGUAGE_ZONE ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

		} elseif ( is_year() ) {
			$message = sprintf( _x( 'Yearly Archives: %s', 'archive template title', LANGUAGE_ZONE ), '<span>' . get_the_date( 'Y' ) . '</span>' );

		} elseif ( is_tax('dt_portfolio_category') ) {
			$term = get_queried_object();
			$tax = get_taxonomy( $term->taxonomy );
			$message = sprintf( _x( 'Portfolio Archives: %s', 'archive template title', LANGUAGE_ZONE ), '<span>' . single_term_title( $tax->labels->name, false ) . '</span>' );

		} elseif ( is_tax('dt_gallery_category') ) {
			$term = get_queried_object();
			$tax = get_taxonomy( $term->taxonomy );
			$message = sprintf( _x( 'Albums Archives: %s', 'archive template title', LANGUAGE_ZONE ), '<span>' . single_term_title( $tax->labels->name, false ) . '</span>' );

		} else {
			$message = _x( 'Archives:', 'archive template title', LANGUAGE_ZONE );

		}

		$title = sprintf( $title_template, $message );
	} elseif ( is_404() ) {
		$title = sprintf( $title_template, _x('Page not found', 'index title', LANGUAGE_ZONE) );
	} else {
		$title = sprintf( $title_template, _x('Blog', 'index title', LANGUAGE_ZONE) );
	}

	echo $before_title;
	echo apply_filters( 'presscore_page_title', $title, $title_template );
	echo $breadcrumbs ? presscore_get_breadcrumbs() : '';
	echo $after_title;
}
add_action('presscore_before_main_container', 'presscore_page_title_controller', 16);

/**
 * Add sorting fields to category list.
 */
function presscore_add_sorting_for_category_list( $html ) {
	return $html . presscore_get_categorizer_sorting_fields();
}
add_filter( 'presscore_get_category_list', 'presscore_add_sorting_for_category_list', 15 );

/**
 * Categorizer wrap.
 *
 */
function presscore_add_wrap_for_catgorizer( $html, $args ) {
	if ( $html ) {

		// get class or use default one
		$class = empty($args['class']) ? 'filter' : $args['class'];

		// wrap categorizer
		$html = '<div class="' . esc_attr($class) . '">' . $html . '</div>';
	}

	return $html;
}
add_filter( 'presscore_get_category_list', 'presscore_add_wrap_for_catgorizer', 16, 2 );

/**
 * Controlls display of widgetarea.
 */
function presscore_widgetarea_controller() {
	global $post;
	
	if ( is_404() ) {
		remove_action('presscore_after_main_container', 'presscore_add_footer_widgetarea', 15);
		remove_action('presscore_after_content', 'presscore_add_sidebar_widgetarea', 15);
	}

	// index or search or archive or no post data
	if ( is_archive() || is_search() || is_home() || is_404() || empty($post) ) return;

	$footer_display = get_post_meta( $post->ID, '_dt_footer_show',  true );
	$sidebar_position = get_post_meta( $post->ID, '_dt_sidebar_position',  true );

	if ( !$footer_display ) {
		remove_action('presscore_after_main_container', 'presscore_add_footer_widgetarea', 15);
	}

	if ( 'disabled' == $sidebar_position ) {
		remove_action('presscore_after_content', 'presscore_add_sidebar_widgetarea', 15);
	}
}
add_action('presscore_before_main_container', 'presscore_widgetarea_controller', 15);

/**
 * Controlls display of post meta.
 */
function presscore_post_meta_new_controller() {
	// get theme options
	$post_meta = of_get_option( 'general-blog_meta_on', 1 );

	if ( $post_meta ) {

		$post_author = of_get_option( 'general-blog_meta_author', 1 );
		$post_categories = of_get_option( 'general-blog_meta_categories', 1 );
		$post_comments = of_get_option( 'general-blog_meta_comments', 1 );
		$post_format_icon = of_get_option( 'general-blog_meta_postformat', 1 );

		// add filters
		if ( $post_author ) {
			add_filter('presscore_new_posted_on-post', 'presscore_get_post_author', 13);
		}

		if ( $post_categories ) {
			add_filter('presscore_new_posted_on-post', 'presscore_get_post_categories', 14);
		}

		if ( $post_comments ) {
			add_filter('presscore_new_posted_on-post', 'presscore_get_post_comments', 15);
		}

		if ( is_single() ) {

			$post_tags = of_get_option( 'general-blog_meta_tags', 1 );
			$post_date = of_get_option( 'general-blog_meta_date', 1 );

			if ( $post_date ) {
				add_filter('presscore_new_posted_on-post', 'presscore_get_post_data', 12);
			}

			if ( $post_tags ) {
				add_filter('presscore_new_posted_on-post', 'presscore_get_post_tags', 17);
			}

		} elseif ( !$post_format_icon ) {

			remove_filter( 'post_class', 'presscore_add_post_format_classes' );
			add_filter( 'post_class', 'presscore_remove_post_format_classes' );
		}

		// add wrap
		add_filter('presscore_new_posted_on-post', 'presscore_get_post_meta_wrap', 16, 2);
	}

}
add_action('presscore_before_main_container', 'presscore_post_meta_new_controller', 15);


/**
 * Controlls display of post meta for general purpose.
 */
function presscore_post_meta_new_general_controller() {
	// add filters
	add_filter('presscore_new_posted_on', 'presscore_get_post_data', 12);
	add_filter('presscore_new_posted_on', 'presscore_get_post_author', 13);
	add_filter('presscore_new_posted_on', 'presscore_get_post_categories', 14);
	add_filter('presscore_new_posted_on', 'presscore_get_post_comments', 15);

	// add wrap
	add_filter('presscore_new_posted_on', 'presscore_get_post_meta_wrap', 16, 2);

}
add_action('presscore_before_main_container', 'presscore_post_meta_new_general_controller', 15);


/**
 * Controlls display of post meta for dt_gallery.
 */
function presscore_post_meta_new_gallery_controller() {
	// add filters
	add_filter('presscore_new_posted_on-dt_gallery', 'presscore_get_post_data', 12);
	add_filter('presscore_new_posted_on-dt_gallery', 'presscore_get_post_categories', 14);

	// add wrap
	add_filter('presscore_new_posted_on-dt_gallery', 'presscore_get_post_meta_wrap', 16, 2);

}
add_action('presscore_before_main_container', 'presscore_post_meta_new_gallery_controller', 15);


/**
 * Controlls display of dt_portfolio meta.
 */
function presscore_portfolio_meta_new_controller() {
	global $post;

	// get theme options
	$post_meta = of_get_option( 'general-portfolio_meta_on', 1 );

	if ( $post_meta ) {

		$post_date = of_get_option( 'general-portfolio_meta_date', 1 );
		$post_author = of_get_option( 'general-portfolio_meta_author', 1 );
		$post_categories = of_get_option( 'general-portfolio_meta_categories', 1 );
		$post_comments = of_get_option( 'general-portfolio_meta_comments', 1 );

		if ( $post_date ) {
			add_filter('presscore_new_posted_on-dt_portfolio', 'presscore_get_post_data', 12);
		}

		if ( $post_author ) {
			add_filter('presscore_new_posted_on-dt_portfolio', 'presscore_get_post_author', 13);
		}

		if ( $post_categories ) {
			add_filter('presscore_new_posted_on-dt_portfolio', 'presscore_get_post_categories', 14);
		}

		if ( $post_comments ) {
			add_filter('presscore_new_posted_on-dt_portfolio', 'presscore_get_post_comments', 15);
		}

		add_filter('presscore_new_posted_on-dt_portfolio', 'presscore_get_post_meta_wrap', 16, 2);
	}

}
add_action('presscore_before_main_container', 'presscore_portfolio_meta_new_controller', 15);


/**
 * Fancy header controller.
 *
 */
function presscore_fancy_header_controller() {
	$config = Presscore_Config::get_instance();

	if ( 'fancy' != $config->get('header_title') ) {
		return;
	}

	// turn off regular titles and breadcrumbs
	remove_action('presscore_before_main_container', 'presscore_page_title_controller', 16);

	$title_color_esc = esc_attr($config->get('fancy_header_title_color'));

	// title and sub title
	$title = '';
	if ( $config->get('fancy_header_title') ) {
		$title .= '<h1 class="fancy-title"';
		if ( $title_color_esc ) $title .= ' style="color: ' . $title_color_esc . '"';
		$title .= '>' . wp_kses_post( $config->get('fancy_header_title') ) . '</h1>'; 
	}

	if ( $config->get('fancy_header_subtitle') ) {
		$title .= '<h2 class="fancy-subtitle"';
		if ( $config->get('fancy_header_subtitle_color') ) $title .= ' style="color: ' . esc_attr($config->get('fancy_header_subtitle_color')) . '"';
		$title .= '>' . wp_kses_post( $config->get('fancy_header_subtitle') ) . '</h2>'; 
	}

	if ( $title ) { $title = '<div class="wf-td hgroup">' . $title . '</div>'; }

	// breadcrumbs

	// remove wrap from bredcrumbs
	remove_filter( 'presscore_get_breadcrumbs', 'presscore_add_divider_wrap_to_breadcrumbs', 15 );
	$breadcrumbs = presscore_get_breadcrumbs();
	add_filter( 'presscore_get_breadcrumbs', 'presscore_add_divider_wrap_to_breadcrumbs', 15 );

	// paint breadcrumbs
	if ( $title_color_esc ) {
		$breadcrumbs = str_replace('<a', '<a style="color: ' . esc_attr($title_color_esc) . ';"', $breadcrumbs);
	}

	$content = $title . $breadcrumbs;

	// container classes
	$container_classes = array( 'fancy-header' );
	switch ( $config->get('fancy_header_title_aligment') ) {
		case 'center': $container_classes[] = 'title-center'; break;
		case 'right':
			$container_classes[] = 'title-right';
			$content = $breadcrumbs . $title;
			break;
		default: $container_classes[] = 'title-left';
	}

	// parallax
	$data_attr = array();
	if ( $config->get('fancy_header_parallax_speed') ) {
		$container_classes[] = 'fancy-parallax-bg';

		$data_attr[] = 'data-prlx-speed="' . $config->get('fancy_header_parallax_speed') . '"';
	}

	// container style
	$container_style = array();
	if ( $config->get('fancy_header_bg_color') ) {
		$container_style[] = 'background-color: ' . $config->get('fancy_header_bg_color');
	}

	if ( $config->get('fancy_header_bg_image') ) {
		$repeat = $config->get('fancy_header_bg_repeat');
		$fullscreen = $config->get('fancy_header_bg_fullscreen');
		if ( $fullscreen ) {
			$repeat = 'no-repeat';
		}
		$bg_attrs = implode( ' ', array( $repeat , $config->get('fancy_header_bg_position_x') , $config->get('fancy_header_bg_position_y') ) );

		$image_meta = wp_get_attachment_image_src( current($config->get('fancy_header_bg_image')), 'full' );
		if ( $image_meta ) {
			$container_style[] = 'background: url(\'' . $image_meta[0] . '\') ' . $bg_attrs;

			if ( $fullscreen ) {
				$container_style[] = 'background-size: cover';
			}

			if ( $config->get('fancy_header_bg_fixed') ) {
				$container_style[] = 'background-attachment: fixed';
			}
		}
	}

	// header height
	$min_h_height = ' style="min-height: ' . $config->get('fancy_header_height') . 'px;"';
	$wf_table_height = ' style="height: ' . $config->get('fancy_header_height') . 'px;"';
	$container_style[] = 'min-height: ' . $config->get('fancy_header_height') . 'px';

	printf(
		'<header id="fancy-header" class="%1$s" style="%2$s" %3$s>
		<div class="wf-wrap">
			<div class="wf-table"%5$s><div class="wf-td td-for-height"><div class="min-h"%6$s></div></div>%4$s</div>
		</div>
		</header>',
		esc_attr( implode( ' ', $container_classes ) ),
		esc_attr( implode( '; ', $container_style ) ),
		implode( ' ', $data_attr ),
		$content,
		$wf_table_height,
		$min_h_height
	);
}
add_action('presscore_before_main_container', 'presscore_fancy_header_controller', 15);

/**
 * Slideshow controller.
 *
 */
function presscore_slideshow_controller() {
	global $post;
	$config = Presscore_Config::get_instance();

	if ( 'slideshow' != $config->get('header_title') ){
		return;
	}

	$slider_id = $config->get('slideshow_sliders');

	// turn off regular titles and breadcrumbs
	remove_action('presscore_before_main_container', 'presscore_page_title_controller', 16);

	if ( dt_get_paged_var() > 1 ) {
		return;
	}

	switch ( $config->get('slideshow_mode') ) {
		case 'porthole':
			$class = 'fixed' == $config->get('slideshow_layout') ? 'class="fixed" ' : '';

			$height = absint($config->get( 'slideshow_slider_height' ));
			$width = absint($config->get( 'slideshow_slider_width' ));
			if ( !$height ) {
				$height = 500;
			}

			if ( !$width ) {
				$width = 1200;
			}

			printf( '<div id="main-slideshow" %sdata-width="%d" data-height="%d" data-autoslide="%d" data-scale="%s" data-paused="%s"></div>',
				$class,
				$width,
				$height,
				absint($config->get('slideshow_autoslide_interval')),
				'fit' == $config->get('slideshow_slider_scaling') ? 'fit' : 'fill',
				'paused' == $config->get('slideshow_autoplay') ? 'true' : 'false'
			);

			add_action( 'wp_footer', 'presscore_render_porthole_slider_data', 15 );

			break;
		case 'metro':
			$slideshow = Presscore_Inc_Slideshow_Post_Type::get_by_id( $slider_id );

			// prepare data
			if ( $slideshow->have_posts() ) {

				$slideshow_objects = array();

				while ( $slideshow->have_posts() ) {

					$slideshow->the_post();

					$media_items = get_post_meta( $post->ID, '_dt_slider_media_items', true );
					if ( empty($media_items) ) {
						continue;
					}

					$attachments_data = presscore_get_attachment_post_data( $media_items );

					if ( count($attachments_data) > 1 ) {

						$object = array();
						foreach ( $attachments_data as $array ) {
							$object[] = Presscoe_Inc_Classes_SwapperSlider::array_to_object( $array );
						}
					} else {

						$object = Presscoe_Inc_Classes_SwapperSlider::array_to_object( current($attachments_data) );
					}

					$slideshow_objects[] = $object;
				}
				wp_reset_postdata();
				
				echo Presscoe_Inc_Classes_SwapperSlider::get_html( $slideshow_objects );
			}
			break;

		case '3d':

			$class = '';
			$data_attr = '';
			$slider_layout = $config->get('slideshow_3d_layout');

			if ( in_array( $slider_layout, array( 'prop-fullwidth', 'prop-content-width' ) ) ) {

				$class = ('prop-fullwidth' == $slider_layout) ? 'class="fixed-height" ' : 'class="fixed" ';

				$width = $config->get('slideshow_3d_slider_width');
				$height = $config->get('slideshow_3d_slider_height');
				$data_attr = sprintf( ' data-width="%d" data-height="%d"',
					$width ? absint($width) : 2500,
					$height ? absint($height) : 1200
				);
			}

			printf( '<div id="main-slideshow" %s><div class="three-d-slider"%s><span id="loading">0</span></div></div>',
				$class,
				$data_attr
			);

			add_action( 'wp_footer', 'presscore_render_3d_slider_data', 15 );

			break;

		case 'revolution':
			$rev_slider = $config->get('slideshow_revolution_slider');

			if ( $rev_slider ) {

				echo '<div id="main-slideshow">';
				putRevSlider( $rev_slider );
				echo '</div>';
			}
	} // switch

}
add_action('presscore_before_main_container', 'presscore_slideshow_controller', 15);

/**
 * Porthole slider data.
 *
 */
function presscore_render_porthole_slider_data() {
	global $post;
	$config = Presscore_Config::get_instance();

	$slider_id = $config->get('slideshow_sliders');
	$slideshows = Presscore_Inc_Slideshow_Post_Type::get_by_id( $slider_id );

	if ( !$slideshows || !$slideshows->have_posts() ) return;

	$slides = array();
	foreach ( $slideshows->posts as $slideshow ) {
		$media_items = get_post_meta( $slideshow->ID, '_dt_slider_media_items', true );
		if ( empty($media_items) ) continue;

		$slides = array_merge( $slides, $media_items );
	}
	$slides = array_unique($slides);

	$media_args = array(
		'posts_per_page'	=> -1,
		'post_type'         => 'attachment',
		'post_mime_type'    => 'image',
		'post_status'       => 'inherit',
		'post__in'			=> $slides,
		'orderby'			=> 'post__in',
	);
	$media_query = new WP_Query( $media_args );

	// prepare data
	if ( $media_query->have_posts() ) {

		echo '<ul id="main-slideshow-content" class="royalSlider rsHomePorthole">';

		while ( $media_query->have_posts() ) { $media_query->the_post();

			$video_url = get_post_meta( $post->ID, 'dt-video-url', true );
			$img_link = get_post_meta( $post->ID, 'dt-img-link', true );
			$thumb_meta = wp_get_attachment_image_src( $post->ID, 'thumbnail' );

			$img_custom = 'data-rsTmb="' . $thumb_meta[0] . '"';
			if ( $video_url ) {
				$img_custom .= ' data-rsVideo="' . esc_url( $video_url ) . '"';
			}

			$img_args = array(
				'img_meta'	=> wp_get_attachment_image_src( $post->ID, 'full' ),
				'img_id'	=> $post->ID,
				'img_class'	=> 'rsImg',
				'custom'	=> $img_custom,
				'echo'		=> false,
				'wrap'		=> '<img %IMG_CLASS% %SRC% %CUSTOM% %ALT% />',
			);
			$image = dt_get_thumb_img( $img_args );

			$caption = '';

			if ( $title = get_the_title() ) {
				$caption .= '<div class="rsTitle">' . $title . '</div>';
			}

			if ( $img_link ) {
				$caption .= sprintf( '<a class="rsCLink" href="%s"><span class="assistive-text">%s</span></a>',
					esc_url( $img_link ),
					_x('details', 'header slideshow', LANGUAGE_ZONE)
				);
			}

			if ( $content = get_the_content() ) {
				$caption .= '<div class="rsDesc">' . $content . '</div>';
			}

			if ( $caption ) {
				$caption = sprintf( '<figure class="rsCapt rsABlock">%s</figure>', $caption );
			}

			printf( '<li>%s</li>', $image . $caption );
		}
		wp_reset_postdata();

		echo '</ul>';
	}
}

/**
 * Render 3D slider.
 *
 */
function presscore_render_3d_slider_data() {
	global $post;
	$config = Presscore_Config::get_instance();

	$slider_id = $config->get('slideshow_sliders');
	$slideshows = Presscore_Inc_Slideshow_Post_Type::get_by_id( $slider_id );

	if ( !$slideshows || !$slideshows->have_posts() ) {
		return;
	}

	$slides = array();
	foreach ( $slideshows->posts as $slideshow ) {

		$media_items = get_post_meta( $slideshow->ID, '_dt_slider_media_items', true );
		if ( empty($media_items) ) {
			continue;
		}

		$slides = array_merge( $slides, $media_items );
	}

	$attachments_data = presscore_get_attachment_post_data( $slides );

	$count = count($attachments_data);
	if ( $count < 10 ) {

		$chunks = array( $attachments_data, array(), array() );
	} else {

		$length = ceil( $count/3 );
		$chunks = array_chunk( $attachments_data, $length );
	}

	$chunks = array_reverse( $chunks );

	foreach ( $chunks as $layer=>$images ) {

		printf( '<div id="level%d" class="plane">' . "\n", $layer + 1 );

		foreach ( $images as $img ) {
			printf( '<img src="%s" alt="%s" />' . "\n", esc_url($img['full']), esc_attr($img['description']) );
		}

		echo "</div>\n";
	}

}

/**
 * Main container class filter.
 *
 * @param $classes array
 *
 * @return array
 */
function presscore_main_container_class_filter( $classes = array() ) {
	global $post;
	$config = Presscore_Config::get_instance();

	// default sidebar position
	$sidebar_position = 'right';

	if ( !empty($post) && !is_home() && !is_search() && !is_archive() && !is_404() ) {

		// if regular page or post - get sidebar position
		$sidebar_position = get_post_meta( $post->ID, '_dt_sidebar_position',  true );
	} elseif ( is_404() ) {

		// set sidebar position to disabled for 404
		$sidebar_position = 'disabled';
	}

	switch( $sidebar_position ) {
		case 'left': $classes[] = 'sidebar-left'; break;
		case 'disabled': $classes[] = 'sidebar-none'; break;
		default : $classes[] = 'sidebar-right';
	}

	return $classes;
}
add_filter('presscore_main_container_classes', 'presscore_main_container_class_filter');

/**
 * Display page content before.
 * Used in presscore_page_content_controller
 */
function presscore_get_page_content_before() {
	if ( get_the_content() ) {
		echo '<div class="page-info">';
		the_content();
		echo '</div>';
	}
}

/**
 * Display page content after.
 * Used in presscore_page_content_controller
 */
function presscore_get_page_content_after() {
	if ( get_the_content() ) {
		echo '<div>';
		the_content();
		echo '</div>';
	}
}

/**
 * Add footer widgetarea.
 */
function presscore_add_footer_widgetarea() {
	get_sidebar( 'footer' );
}
add_action('presscore_after_main_container', 'presscore_add_footer_widgetarea', 15);

/**
 * Add sidebar widgetarea.
 */
function presscore_add_sidebar_widgetarea() {
	get_sidebar();
}
add_action('presscore_after_content', 'presscore_add_sidebar_widgetarea', 15);

/**
 * Page masonry controller.
 *
 * Filter classes used in post masonry wrap.
 */
function presscore_page_masonry_controller() {
	$config = Presscore_Config::get_instance();

	// add masonry wrap
	if ( in_array( $config->get('layout'), array('masonry', 'grid') ) ) {

		add_action('presscore_before_post', 'presscore_before_post_masonry', 15);
		add_action('presscore_after_post', 'presscore_after_post_masonry', 15);
	}
}
add_action('presscore_before_loop', 'presscore_page_masonry_controller', 15);

/**
 * Add post open div for masonry layout.
 */
function presscore_before_post_masonry() {
	global $post;

	$config = Presscore_Config::get_instance();
	$post_type = get_post_type();

	// get template based columns class
	$wf_class = 'wf-1-';
	if ( $config->get('columns') ) {

		$wf_class .= absint( $config->get('columns') );
	}else {

		$wf_class .= '3';
	}

	// get post width settings
	$post_preview = 'normal';
	if ( 'post' == $post_type ) {

		$post_preview = get_post_meta($post->ID, '_dt_post_options_preview', true);
	} else if ( 'dt_portfolio' == $post_type ) {

		$post_preview = get_post_meta($post->ID, '_dt_project_options_preview', true);
	} else if ( 'dt_gallery' == $post_type ) {

		$post_preview = get_post_meta($post->ID, '_dt_album_options_preview', true);
	}

	// if posts have not same size
	if ( !$config->get('all_the_same_width') && 'wide' == $post_preview ) {
		$wf_wide = array(
			'wf-1-2'	=> 'wf-1',
			'wf-1-3'	=> 'wf-2-3',
			'wf-1-4'	=> 'wf-1-2',
		);

		if ( isset($wf_wide[ $wf_class ]) ) {
			$wf_class = $wf_wide[ $wf_class ];
		}
	}

	$iso_classes = array( 'wf-cell', $wf_class );

	if ( 'masonry' == $config->get('layout') ) {
		$iso_classes[] = 'iso-item';
	}

	if ( in_array( $config->get('template'), array('portfolio', 'albums') ) ) {

		// set taxonomy based on post_type
		$tax = null;
		switch ( $post_type ) {
			case 'dt_portfolio': $tax = 'dt_portfolio_category'; break;
			case 'dt_gallery': $tax = 'dt_gallery_category'; break;
		}

		// add terms to classes
		$terms = wp_get_object_terms( $post->ID, $tax, array('fields' => 'ids') );
		if ( $terms && !is_wp_error($terms) ) {

			foreach ( $terms as $term_id ) {

				$iso_classes[] = 'category-' . $term_id;
			}
		} else {

			$iso_classes[] = 'category-0';
		}
	}

	$iso_classes = esc_attr(implode(' ', $iso_classes));

	$clear_title = $post->post_title;

	echo '<div class="' . $iso_classes . '" data-date="' . get_the_date( 'c' ) . '" data-name="' . esc_attr($clear_title) . '">';
}

/**
 * Add post close div for masonry layout.
 */
function presscore_after_post_masonry() {
	echo '</div>';
}

/**
 * Testimonials list layout post container.
 *
 */
function presscore_before_post_testimonials_list() {
	echo '<div class="wf-cell wf-1">';
}

/**
 * Turn off categories and details link on portfolio templates.
 */
function presscore_portfolio_template_options_terms_and_details_controller() {
	global $post;
	$config = Presscore_Config::get_instance();

	if ( 'portfolio' != $config->get('template') ) {
		return;
	}

	// get options
	if ( '0' === $config->get('show_terms') ) {
		remove_filter('presscore_posted_on', 'presscore_get_post_categories', 14);
	}

	if ( '0' === $config->get('show_details') ) {
		add_filter('presscore_post_details_link', 'presscore_return_empty_string');
	}
}
add_action('presscore_before_loop', 'presscore_portfolio_template_options_terms_and_details_controller');

// TODO: maybe refactor this.
/**
 * Add proportions to images.
 *
 * @return array.
 */
function presscore_add_thumbnail_class_for_masonry( $args = array() ) {
	$config = Presscore_Config::get_instance();
	$prop = $config->get('thumb_proportions');

	if ( 'resize' == $config->get('image_layout') && $prop ) {
		$args['prop'] = presscore_meta_boxes_get_images_proportions( $prop );
	}

	return $args;
}
add_filter( 'dt_portfolio_thumbnail_args', 'presscore_add_thumbnail_class_for_masonry', 15 );
add_filter( 'dt_post_thumbnail_args', 'presscore_add_thumbnail_class_for_masonry', 15 );
add_filter( 'presscore_get_images_gallery_hoovered-title_img_args', 'presscore_add_thumbnail_class_for_masonry', 15 );

/**
 * Add preload-me to every image that created with dt_get_thumb_img().
 *
 */
function presscore_add_preload_me_class_to_images( $args = array() ) {
	$img_class = $args['img_class'];
	
	// clear
	$img_class = str_replace('preload-me', '', $img_class);
	
	// add class
	$img_class .= ' preload-me';
	$args['img_class'] = trim( $img_class );

	return $args;
}
add_filter( 'dt_get_thumb_img-args', 'presscore_add_preload_me_class_to_images', 15 );

/**
 * Attempt to exclude featured image from hoovered gallery in albums.
 * Works only in the loop.
 */
function presscore_gallery_post_exclude_featured_image_from_gallery( $args = array(), $default_args = array(), $options = array() ) {
	global $post;

	if ( in_the_loop() && get_post_meta( $post->ID, '_dt_album_options_exclude_featured_image', true ) ) {
		$args['custom'] = isset($args['custom']) ? $args['custom'] : trim(str_replace( $options['links_rel'], '', $default_args['custom'] ));
		$args['class'] = $default_args['class'] . ' ignore-feaured-image';
	}

	return $args;
}

/**
 * Set portfolio thumbnail sizes.
 *
 * @return array.
 */
function presscore_portfolio_thumbnail_change_args( $args = array() ) {
	global $post;
	$config = Presscore_Config::get_instance();

	// preview mode for blog
	if ( 'portfolio' == $config->get('template') && !empty($args['options']) ) {
		
		// wide portfolio
		$post_preview = get_post_meta($post->ID, '_dt_portfolio_options_preview', true);
		if ( 'wide' == $post_preview ) {
			$args['options'] = array_merge( $args['options'], array('w' => 270, 'zc' => 3, 'z' => 0) );
		}
	}

	return $args;
}
add_filter( 'dt_portfolio_thumbnail_args', 'presscore_portfolio_thumbnail_change_args', 15 );

/**
 * Return empty string.
 *
 * @return string
 */
function presscore_return_empty_string() {
	return '';
}

/**
 * Add anchor #more-{$post->ID} to href.
 *
 * @return string
 */
function presscore_add_more_anchor( $content = '' ) {
	global $post;

	if ( $post ) {
		$content = preg_replace( '/href=[\'"]?([^\'" >]+)/', 'href="$1#more-' . $post->ID . '"', $content );
	}

	// added in helpers.php:3120+
	remove_filter( 'presscore_post_details_link', 'presscore_add_more_anchor', 15 );
	return $content;
}

/**
 * Replace default excerpt more to &hellip;
 *
 * @return string
 */
function presscore_excerpt_more_filter( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'presscore_excerpt_more_filter' );

/**
 * Add post password form to excerpts.
 *
 * @return string
 */
function presscore_add_password_form_to_excerpts( $content ) {
	if ( post_password_required() ) {
		$content = get_the_password_form();
	}

	return $content;
}
add_filter( 'the_excerpt', 'presscore_add_password_form_to_excerpts', 99 );

/**
 * Add post format classes to post.
 */
function presscore_add_post_format_classes( $classes = array() ) {
	global $post;

	if ( 'post' != get_post_type( $post ) ) {
		return $classes;
	}

	$post_format_class = presscore_get_post_format_class();
	if ( $post_format_class ) {
		$classes[] = $post_format_class;
	}

	return array_unique($classes);
}
add_filter( 'post_class', 'presscore_add_post_format_classes' );

/**
 * Remove post format classes.
 */
function presscore_remove_post_format_classes( $classes = array() ) {
	$post_format = get_post_format();

	return array_diff( $classes, array('format-' . $post_format) );
}

/**
 * Post pagination controller.
 */
function presscore_post_navigation_controller() {
	if ( !in_the_loop() ) {
		return;
	}

	$show_navigation = presscore_is_post_navigation_enabled();

	// show navigation
	if ( $show_navigation ) {
		presscore_post_navigation();
	}
}

/**
 * Change config, categorizer.
 *
 */
function presscore_react_on_categorizer() {
	
	if ( !isset($_REQUEST['term'], $_REQUEST['order'], $_REQUEST['orderby']) ) {
		return;
	}

	$config = Presscore_Config::get_instance();

	// sanitize
	if ( '' == $_REQUEST['term'] ) {
		$display = array();
	} else if ( 'none' == $_REQUEST['term'] ) {
		$display = array( 'terms_ids' => array(0), 'select' => 'except' );
	} else {
		$display = array( 'terms_ids' => array( absint($_REQUEST['term']) ), 'select' => 'only' );
	}

	$order = esc_attr($_REQUEST['order']);
	$orderby = esc_attr($_REQUEST['orderby']);

	$config->set('order', $order);
	$config->set('orderby', $orderby);

	$config->set('request_display', $display);

	add_filter( 'presscore_get_category_list-args', 'presscore_filter_categorizer_current_arg', 15 );
}
add_action('init', 'presscore_react_on_categorizer', 15);

/**
 * Categorizer current filter.
 *
 */
function presscore_filter_categorizer_current_arg( $args ) {
	$config = Presscore_Config::get_instance();

	$display = $config->get('request_display');

	if ( !$display ) {
		return $args;
	}

	if ( 'only' == $display['select'] && !empty($display['terms_ids']) ) {
		$args['current'] = current($display['terms_ids']);
	} else if ( 'except' == $display['select'] && 0 == current($display['terms_ids']) ) {
		$args['current'] = 'none';
	}
	return $args;
}

/**
 * Categorizer hash filter.
 *
 */
function presscore_filter_categorizer_hash_arg( $args ) {
	$config = Presscore_Config::get_instance();

	$order = $config->get('order');
	$orderby = $config->get('orderby');

	$hash = add_query_arg( array('term' => '%TERM_ID%', 'orderby' => $orderby, 'order' => $order), get_permalink() );

	$args['hash'] = $hash;

	return $args;
}
add_filter( 'presscore_get_category_list-args', 'presscore_filter_categorizer_hash_arg', 15 );

/**
 * Add divider and gaps instead of related projects if it's turned off.
 *
 */
function presscore_add_divider_if_related_projects_turned_off( $html = '' ) {
	if ( !$html && ( comments_open() || 0 != get_comments_number() ) ) {
		$html = '<div class="hr-thick"></div><div class="gap-30"></div>';
	}
	return $html;
}
add_filter( 'presscore_display_related_projects', 'presscore_add_divider_if_related_projects_turned_off', 15 );

/**
 * Wrap breadcrumbs in divider.
 *
 */
function presscore_add_divider_wrap_to_breadcrumbs( $breadcrumbs = '' ) {
	if ( $breadcrumbs ) { $breadcrumbs = '<div class="hr-breadcrumbs divider-heder">' . $breadcrumbs . '</div>'; }
	return $breadcrumbs;
}
add_filter( 'presscore_get_breadcrumbs', 'presscore_add_divider_wrap_to_breadcrumbs', 15 );

/**
 * Wrap edit link in p tag.
 *
 */
function presscore_wrap_edit_link_in_p( $link = '' ){
	if ( $link ) {
		$link = '<p>' . $link . '</p>';
	}
	return $link;
}
add_filter( 'presscore_post_edit_link', 'presscore_wrap_edit_link_in_p', 15 );

/**
 * Set retina flag.
 *
 */
function presscore_retina_on( $flag = false ) {
	return absint( of_get_option( 'general-hd_images', 1 ) );
}
add_filter( 'dt_retina_on', 'presscore_retina_on', 15 );

/**
 * Prepare image video url.
 *
 */
function presscore_prepare_video_url_for_attachments_post_data( $data = array() ) {

	if ( isset( $data['video_url'] ) ) {
		$data['video_url'] = presscore_prepare_video_url( $data['video_url'] );
	}

	return $data;
}
add_filter( 'presscore_get_attachment_post_data-attachment_data', 'presscore_prepare_video_url_for_attachments_post_data', 15 );

/**
 * Add description to images.
 *
 */
function presscore_add_default_meta_to_images( $args = array() ) {

	// add description to images if it's not defined
	if ( $id = absint($args['img_id']) ) {

		if ( !$args['title'] ) {
			$attachment = get_post( $id );
			$args['title'] = wp_kses($attachment->post_content, array());
		}

		// use image title instead alt
		$args['alt'] = get_the_title( $id );
	}

	return $args;
}
add_filter( 'dt_get_thumb_img-args', 'presscore_add_default_meta_to_images', 15 );

/**
 * For blog posts only show next/prev posts titles.
 *
 */
function presscore_show_navigation_next_prev_posts_titles( $args = array() ) {
	$args['next_post_text']	= '%title';
	$args['prev_post_text']	= '%title';
	return $args;
}

/**
 * Primary navigation menu.
 *
 */
function presscore_add_primary_menu() {
	$logo_align = of_get_option( 'header-layout', 'left' );
?>
	<!-- !- Navigation -->
	<nav id="navigation"<?php if ( 'left' == $logo_align ) echo ' class="wf-td"'; elseif ( in_array( $logo_align, array('classic', 'classic-centered') ) ) echo ' class="wf-wrap"'; ?>>
		<?php
		dt_menu( array(
			'menu_wraper' 		=> '<ul id="main-nav" class="fancy-rollovers wf-mobile-hidden">%MENU_ITEMS%' . "\n" . '</ul>',
			'menu_items'		=>  "\n" . '<li class="%ITEM_CLASS%"><a href="%ITEM_HREF%">%ITEM_TITLE%</a>%SUBMENU%</li> ',
			'submenu' 			=> '<ul class="sub-nav">%ITEM%</ul>',
			'parent_clicable'	=> of_get_option( 'header-submenu_parent_clickable', true ),
			'params'			=> array( 'act_class' => 'act' ),
		) );
		?>

		<?php if ( !( class_exists('UberMenuStandard') && has_nav_menu('primary') ) ) : ?>

		<a href="#show-menu" rel="nofollow" id="mobile-menu">
			<span class="menu-open"><?php _e( 'MENU', LANGUAGE_ZONE ); ?></span>
			<span class="menu-close"><?php _e( 'CLOSE', LANGUAGE_ZONE ); ?></span>
			<span class="menu-back"><?php _e( 'back', LANGUAGE_ZONE ); ?></span>
			<span class="wf-phone-visible">&nbsp;</span>
		</a>

		<?php endif; ?>

		<?php if ( of_get_option('header-search_show', 1) && 'left' != $logo_align ) : ?>

			<div class="wf-td mini-search wf-mobile-hidden">
				<?php get_search_form(); ?>
			</div>

		<?php endif; ?>

	</nav>

	<?php if ( of_get_option('header-search_show', 1) && 'left' == $logo_align ) : ?>

		<div class="wf-td mini-search wf-mobile-hidden">
			<?php get_search_form(); ?>
		</div>

	<?php endif; ?>
<?php
}
add_action( 'presscore_primary_navigation', 'presscore_add_primary_menu', 15 );