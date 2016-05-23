<?php
/**
 * presscore functions and definitions.
 *
 * @package presscore
 * @since presscore 0.1
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since presscore 0.1
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}

/**
 * Theme init file.
 *
 */
require( get_template_directory() . '/inc/init.php' );

if ( ! function_exists( 'presscore_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * @since presscore 1.0
	 */
	function presscore_setup() {

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on presscore, use a find and replace
		 * to change LANGUAGE_ZONE to the name of your theme in all the template files
		 */
		load_theme_textdomain( LANGUAGE_ZONE, get_template_directory() . '/languages' );

		/**
		 * Editor style.
		 */
		add_editor_style();

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary' 	=> __( 'Primary Menu', LANGUAGE_ZONE ),
			'top'		=> __( 'Top Menu', LANGUAGE_ZONE ),
			'bottom'	=> __( 'Bottom Menu', LANGUAGE_ZONE ),
		) );

		/**
		 * Enable support for Post Formats
		 */
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'chat', 'status' ) );

		/**
		 * Allow shortcodes in widgets.
		 *
		 */
		add_filter( 'widget_text', 'do_shortcode' );

		// create upload dir
		wp_upload_dir();

		/**
		 * Include core functions.
		 *
		 */
		require_once( PRESSCORE_EXTENSIONS_DIR . '/core-functions.php' );

		/**
		 * Include stylesheet related functions.
		 *
		 */
		require_once( PRESSCORE_EXTENSIONS_DIR . '/stylesheet-functions.php' );

		$is_backend = is_admin() || dt_is_login_page();
		$current_page_name = dt_get_current_page_name();

		/**
		 * Include options framework if it is not installed like plugin.
		 *
		 */
		if ( !defined('OPTIONS_FRAMEWORK_VERSION') ) {

			// Base
			require_once( PRESSCORE_EXTENSIONS_DIR . '/options-framework/options-framework.php' );
		}

		/**
		 * Include custom post typest.
		 *
		 */
		require_once( PRESSCORE_DIR . '/post-types.php' );

		/**
		 * Include admin functions.
		 *
		 */
		if ( is_admin() ) {

			// add theme options
			add_filter( 'options_framework_location', 'presscore_add_theme_options' );

			/**
			 * Include the TGM_Plugin_Activation class.
			 */
			require_once( PRESSCORE_EXTENSIONS_DIR . '/class-tgm-plugin-activation.php' );

			// Include the meta box script
			if ( file_exists( RWMB_DIR . 'meta-box.php' ) ) {

				/**
				 * Include metaboxes overrides.
				 *
				 */
				require_once( PRESSCORE_EXTENSIONS_DIR . '/custom-meta-boxes/override-fields.php' ); 

				/**
				 * Include Meta-Box framework.
				 *
				 */
				require_once( RWMB_DIR . 'meta-box.php' );

				/**
				 * Include custom metaboxes.
				 *
				 */
				require_once( PRESSCORE_EXTENSIONS_DIR . '/custom-meta-boxes/metabox-fields.php' ); 

				/**
				 * Attach metaboxes.
				 *
				 */
				if ( file_exists( PRESSCORE_ADMIN_DIR . '/metaboxes.php' ) ) {
					require_once( PRESSCORE_ADMIN_DIR . '/metaboxes.php' );
				}
			}

			require_once( PRESSCORE_ADMIN_DIR . '/admin-functions.php' );

		} else {

			/**
			 * Include AQResizer.
			 *
			 */
			require_once( PRESSCORE_EXTENSIONS_DIR . '/aq_resizer.php' );

			/**
			 * Include custom menu.
			 *
			 */
			require_once( PRESSCORE_EXTENSIONS_DIR . '/core-menu.php' );

			/**
			 * Include helpers.
			 *
			 */
			require_once( PRESSCORE_DIR . '/helpers.php' );

			/**
			 * Include template actions and filters.
			 *
			 */
			require_once( PRESSCORE_DIR . '/template-tags.php' );

			/**
			 * Include paginator.
			 *
			 */
			require_once( PRESSCORE_EXTENSIONS_DIR . '/dt-pagination.php' );

		}

		/**
		 * Some additional classes ( remove in future ).
		 *
		 */
		require_once( PRESSCORE_CLASSES_DIR . '/tags.class.php' );

		/**
		 * Include widgets.
		 *
		 */

		/* Widgets list */
		$presscore_widgets = array(
			'contact-info.php',
			'custom-menu-1.php',
			'custom-menu-2.php',
			'blog-posts.php',
			'blog-categories.php',
			'flickr.php',
			'portfolio.php',
			'progress-bars.php',
			'testimonials-list.php',
			'testimonials-slider.php',
			'team.php',
			'logos.php',
			'photos.php',
			'contact-form.php',
			'accordion.php',
		);

		$presscore_widgets = apply_filters( 'presscore_widgets', $presscore_widgets );

		// include widgets only for frontend and widgets admin page
		if ( $presscore_widgets && ( in_array($current_page_name, array('widgets.php', 'admin-ajax.php')) || !$is_backend ) ) {

			foreach ( $presscore_widgets as $presscore_widget ) {
				require_once( trailingslashit( PRESSCORE_WIDGETS_DIR ) . $presscore_widget );
			}

		}

		// List of shortcodes folders to include
		// All folders located in /include
		$presscore_shortcodes = array(
			'layout-builder',
			'columns',
			'box',
			'gap',
			'divider',
			'stripes',

			'fancy-image',
			'list',
			'button',
			'tooltips',
			'highlight',
			'code',

			'tabs',
			'accordion',
			'toggles',

			'quote',
			'call-to-action',
			'shortcode-teasers',
			'banner',
			'benefits',
			'progress-bars',
			'contact-form',
			'social-icons',
			'map',

			'blog-posts-small',
			'blog-posts',
			'portfolio',
			'portfolio-slider',
			'small-photos',
			'slideshow',
			'team',
			'testimonials',
			'logos',

			'gallery',

			'animated-text',

			'list-vc',
			'benefits-vc'
		);
		$presscore_shortcodes = apply_filters( 'presscore_shortcodes', $presscore_shortcodes );

		// include shortcodes only for frontend and post admin pages
		if ( $presscore_shortcodes && ( in_array( $current_page_name, array('post.php', 'post-new.php', 'admin-ajax.php') ) || !$is_backend ) ) {

			/**
			 * Setup shortcodes.
			 *
			 */
			require_once( PRESSCORE_SHORTCODES_DIR . '/setup.php' );

			foreach ( $presscore_shortcodes as $shortcode_dirname ) {

				$file_path =  trailingslashit( PRESSCORE_SHORTCODES_INCLUDES_DIR ) . $shortcode_dirname . '/functions.php';

				if ( file_exists( $file_path ) ) {
					require_once( $file_path );
				}
			}
		}

		if ( class_exists( 'Woocommerce' ) ) {

			/**
			 * Add woocommerce support.
			 *
			 */
			require_once( trailingslashit( PRESSCORE_DIR ) . 'woocommerce-support.php' );
		}

		// TODO: finish this in 1.0.7
		if ( class_exists('UberMenuStandard') ) {

			/**
			 * Add ubermenu support.
			 *
			 */
			require_once( trailingslashit( PRESSCORE_DIR ) . 'ubermenu-support.php' );
		}

	}

endif; // presscore_setup

add_action( 'after_setup_theme', 'presscore_setup', 15 );


/**
 * Set theme options path.
 *
 */
function presscore_add_theme_options() {
	return array( 'inc/admin/options.php' );
}


if ( ! function_exists('presscore_layout_builder_controller') ) :

	/**
	 * WYSIWYG layout builder filter.
	 *
	 */
	function presscore_layout_builder_controller() {
		if ( function_exists('of_get_option') && class_exists('DT_ADD_MCE_BUTTON') ) {

			// remove shortcodes buttons from wysiwyg
			if ( of_get_option( 'general-wysiwig_visual_columns' ) ) {

				unset( DT_ADD_MCE_BUTTON::$plugins['columns'] );
				unset( DT_ADD_MCE_BUTTON::$plugins['box'] );
			} else {

				unset( DT_ADD_MCE_BUTTON::$plugins['layout-builder'] );
			}

		}
	}

endif; // presscore_layout_builder_controller

add_filter( 'init', 'presscore_layout_builder_controller' );


if ( ! function_exists( 'presscore_add_presets' ) ) :

	/**
	 * Add theme options presets.
	 *
	 */
	function presscore_add_presets( $presets = array() ) {
		// noimage - /images/noimage_small.jpg

		$theme_presets = array(
			'skin1'			=> array( 'src' => '/inc/presets/icons/skin1.jpg', 'title' => '' ), // Light
			'skin2'			=> array( 'src' => '/inc/presets/icons/skin2.jpg', 'title' => '' ), // Striped
			'skin3'			=> array( 'src' => '/inc/presets/icons/skin3.jpg', 'title' => '' ), // Dark
			'skin4'			=> array( 'src' => '/inc/presets/icons/skin4.jpg', 'title' => '' ), // Jeans
			'skin5'			=> array( 'src' => '/inc/presets/icons/skin5.jpg', 'title' => '' ), // Polygonal
			'skin6'			=> array( 'src' => '/inc/presets/icons/skin6.jpg', 'title' => '' ), // Sepia
		);

		return array_merge( $presets, $theme_presets );
	}

endif;

add_filter( 'optionsframework_get_presets_list', 'presscore_add_presets', 15 );


if ( ! function_exists('presscore_set_first_run_skin') ) :

	/**
	 * Set first run skin.
	 *
	 */
	function presscore_set_first_run_skin( $skin_name = '' ) {
		return 'skin1';
	}

endif; // presscore_set_first_run_skin

add_filter( 'options_framework_first_run_skin', 'presscore_set_first_run_skin' );


if ( ! function_exists( 'presscore_themeoption_preserved_fields' ) ) :

	function presscore_themeoption_preserved_fields( $fields = array() ) {

		$fields = array(
			'widgetareas',
			'header-logo_regular',
			'header-logo_hd',
			'bottom_bar-logo_regular',
			'bottom_bar-logo_hd',
			'bottom_bar-copyrights',
			'bottom_bar-credits',
			'social_buttons-post',
			'social_buttons-portfolio',
			'social_buttons-albums',
			'general-tracking_code',
			'general-favicon',
			'general-wysiwig_visual_columns',

			'top_bar-contact_address',
			'top_bar-contact_phone',
			'top_bar-contact_email',
			'top_bar-contact_skype',
			'top_bar-contact_clock',
			'top_bar-contact_info'
		);

		foreach ( presscore_get_social_icons_data() as $value=>$title ) {
			$fields[] = 'top_bar-soc_ico_' . $value;
		}

		return $fields;
	}

endif; // presscore_themeoption_preserved_fields

add_filter( 'optionsframework_validate_preserve_fields', 'presscore_themeoption_preserved_fields', 15 );


/**
 * Flush your rewrite rules.
 *
 */
function presscore_flush_rewrite_rules() {

	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'presscore_flush_rewrite_rules' );


if ( ! function_exists('presscore_generate_less_css_file_after_options_save') ) :

	/**
	 * Update custom.less stylesheet.
	 *
	 */
	function presscore_generate_less_css_file_after_options_save() {

		$set = get_settings_errors('options-framework');
		if ( !empty( $set ) ) {

			presscore_generate_less_css_file();

			if ( get_option( 'presscore_less_css_is_writable' ) ) {
				add_settings_error( 'presscore-wp-less', 'save_stylesheet', _x( 'Stylesheet saved.', 'backend', LANGUAGE_ZONE ), 'updated fade' );
			}
		}

	}

endif; // presscore_generate_less_css_file_after_options_save

add_action( 'admin_init', 'presscore_generate_less_css_file_after_options_save', 11 );


if ( ! function_exists( 'presscore_generate_less_css_file' ) ) :

	/**
	 * Update custom.less stylesheet.
	 */
	function presscore_generate_less_css_file() {

		/**
		 * Include WP-Less.
		 *
		 */
		require_once( PRESSCORE_EXTENSIONS_DIR . '/wp-less/bootstrap-for-theme.php' );

		// WP-Less init
		if ( class_exists('WPLessPlugin') ) {
			$less = WPLessPlugin::getInstance();
			$less->dispatch();
		}

		/**
		 * Less helpers.
		 *
		 * @since presscore 1.0.6
		 */
		require_once( PRESSCORE_EXTENSIONS_DIR . '/less-functions.php' );

		/**
		 * Less variables.
		 *
		 * @since presscore 0.5
		 */
		require_once( PRESSCORE_DIR . '/less-vars.php' );

		// $less = WPLessPlugin::getInstance();
		$config = $less->getConfiguration();

		if ( !wp_style_is('dt-custom.less', 'registered') ) {
			wp_register_style( 'dt-custom.less', get_template_directory_uri() . '/css/custom.less' );
		}

		// save options
		$options = presscore_compile_less_vars();

		if ( $options ) {
			$less->setVariables( $options );
		}

		WPLessStylesheet::$upload_dir = $config->getUploadDir();
		WPLessStylesheet::$upload_uri = $config->getUploadUrl();

		$less->processStylesheet( 'dt-custom.less', true );
	}

endif; // presscore_generate_less_css_file


if ( ! function_exists('presscore_widgets_init') ) :

	/**
	 * Register widgetized area and
	 *
	 * @since presscore 0.1
	 */
	function presscore_widgets_init() {

		if ( function_exists('of_get_option') ) {

			$w_params = array(
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</section>',
				'before_title' 	=> '<div class="widget-title">',
				'after_title'	=> '</div>'
			);

			$w_areas = apply_filters( 'presscore_widgets_init-sidebars', of_get_option( 'widgetareas', false ) );

			if ( !empty( $w_areas ) && is_array( $w_areas ) ) {

				$prefix = 'sidebar_';

				foreach( $w_areas as $sidebar_id=>$sidebar ) {

					$sidebar_args = array(
						'name' 			=> isset( $sidebar['sidebar_name'] ) ? $sidebar['sidebar_name'] : '',
						'id' 			=> $prefix . $sidebar_id,
						'description' 	=> isset( $sidebar['sidebar_desc'] ) ? $sidebar['sidebar_desc'] : '',
						'before_widget' => $w_params['before_widget'],
						'after_widget' 	=> $w_params['after_widget'],
						'before_title' 	=> $w_params['before_title'],
						'after_title'	=> $w_params['after_title'] 
					);

					$sidebar_args = apply_filters( 'presscore_widgets_init-sidebar_args', $sidebar_args, $sidebar_id, $sidebar );

					register_sidebar( $sidebar_args );
				}

			}

		}
	}

endif; // presscore_widgets_init

add_action( 'widgets_init', 'presscore_widgets_init' );


if ( ! function_exists( 'presscore_enqueue_scripts' ) ) :

	/**
	 * Enqueue scripts and styles.
	 */
	function presscore_enqueue_scripts() {
		$config = Presscore_Config::get_instance();

		$template_uri = get_template_directory_uri();
		$custom_less_path = '/css/custom.less';

		wp_register_style( 'dt-custom.less', $template_uri . $custom_less_path );

		$cache_name = 'wp_less_compiled_'.md5( get_template_directory() . $custom_less_path );
		$compiled_cache = get_transient($cache_name);

		if ( ( defined('WP_DEBUG') && WP_DEBUG ) || ( $compiled_cache !== false && empty($compiled_cache['target_uri']) ) ) {

			presscore_generate_less_css_file();
			$compiled_cache = get_transient($cache_name);
		}

		// enqueue web fonts if needed
		presscore_enqueue_web_fonts();

		wp_enqueue_style( 'dt-normalize', $template_uri . '/css/normalize.css' );
		wp_enqueue_style( 'dt-wireframe', $template_uri . '/css/wireframe.css' );
		wp_enqueue_style( 'dt-main', $template_uri . '/css/main.css' );

		if ( presscore_responsive() ) {

			wp_enqueue_style( 'dt-media', $template_uri . '/css/media.css' );
		}

		// less stylesheet
		if ( get_option( 'presscore_less_css_is_writable' ) && isset($compiled_cache['target_uri']) ) {

			wp_deregister_style( 'dt-custom.less' );
			wp_enqueue_style( 'dt-custom.less', $compiled_cache['target_uri'] );

		// print custom css inline
		} elseif ( !empty($compiled_cache['compiled']) ) {

			wp_add_inline_style( 'dt-main', $compiled_cache['compiled'] );
		} else {

			// get current skin name
			$preset = of_get_option( 'preset', presscore_set_first_run_skin() );

			// load skin precompiled css
			wp_enqueue_style( 'dt-compiled-custom.less', $template_uri . '/css/compiled/custom-' . esc_attr($preset) . '.css' );
		}

		// RoyalSlider
		wp_enqueue_style( 'dt-royalslider', $template_uri . '/royalslider/royalslider.css' );

		wp_enqueue_style( 'dt-prettyPhoto', $template_uri . '/js/plugins/pretty-photo/css/prettyPhoto.css' );

		wp_enqueue_style( 'style', get_stylesheet_uri() );

		// in header
		wp_enqueue_script( 'dt-modernizr', $template_uri . '/js/modernizr.js', array( 'jquery' ) );

		// in footer
		wp_enqueue_script( 'dt-royalslider', $template_uri . '/royalslider/jquery.royalslider.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'dt-prettyPhoto', $template_uri . '/js/plugins/pretty-photo/js/jquery.prettyPhoto.js', array( 'jquery' ), null, true );	
		wp_enqueue_script( 'dt-plugins', $template_uri . '/js/plugins.js', array( 'jquery' ), null, true );	

		wp_enqueue_script( 'dt-main', $template_uri . '/js/main.js', array( 'jquery' ), '1.0', true );
		// wp_enqueue_script( 'dt-animation', $template_uri . '/js/animate-elements.js', array( 'jquery', 'dt-main' ), null, true );

		// add some additional data
		wp_localize_script( 'dt-main', 'dtLocal', array(
			'passText'		=> __('To view this protected post, enter the password below:', LANGUAGE_ZONE),
			'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
			'contactNonce'	=> wp_create_nonce('dt_contact_form'),
		) );

		// additional scripts
		// wp_enqueue_script( 'dt-dev-code', $template_uri . '/js/dt-dev-code.js', array( 'jquery', 'dt-main' ), '1.0', true );

		// comments clear script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$custom_css = of_get_option( 'general-custom_css', '' );
		if ( $custom_css ) {

			wp_add_inline_style( 'style', $custom_css );
		}
	}

endif; // presscore_enqueue_scripts

add_action( 'wp_enqueue_scripts', 'presscore_enqueue_scripts', 15 );


if ( ! function_exists( 'presscore_admin_scripts' ) ) :

	/**
	 * Add metaboxes scripts and styles.
	 */
	function presscore_admin_scripts( $hook ) {
		if ( !in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) {
			return;
		}

		$template_uri = get_template_directory_uri();

		wp_enqueue_style( 'dt-mb-magick', $template_uri . '/inc/admin/assets/admin_mbox_magick.css' );

		wp_enqueue_script( 'dt-metaboxses-scripts', $template_uri . '/inc/admin/assets/custom-metaboxes.js', array('jquery'), false, true );
		wp_enqueue_script( 'dt-mb-magick', $template_uri . '/inc/admin/assets/admin_mbox_magick.js', array('jquery'), false, true );
		wp_enqueue_script( 'dt-mb-switcher', $template_uri . '/inc/admin/assets/admin_mbox_switcher.js', array('jquery'), false, true );

		// for proportion ratio metabox field
		$proportions = presscore_meta_boxes_get_images_proportions();
		$proportions['length'] = count( $proportions );
		wp_localize_script( 'dt-metaboxses-scripts', 'rwmbImageRatios', $proportions );
	}

endif; // presscore_admin_scripts

add_action( 'admin_enqueue_scripts', 'presscore_admin_scripts', 11 );


if ( ! function_exists( 'presscore_setup_admin_scripts' ) ) :

	/**
	 * Add widgets scripts. Enqueued only for widgets.php.
	 */
	function presscore_setup_admin_scripts( $hook ) {

		if ( 'widgets.php' != $hook ) {
			return;
		}

		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		// enqueue wp colorpicker
		wp_enqueue_style( 'wp-color-picker' );

		// presscore stuff
		wp_enqueue_style( 'dt-admin-widgets', PRESSCORE_ADMIN_URI . '/assets/admin-widgets.css' );
		wp_enqueue_script( 'dt-admin-widgets', PRESSCORE_ADMIN_URI . '/assets/admin_widgets_page.js', array('jquery', 'wp-color-picker'), false, true );

		wp_localize_script( 'dt-admin-widgets', 'dtWidgtes', array(
			'title'			=> _x( 'Title', 'widget', LANGUAGE_ZONE ),
			'content'		=> _x( 'Content', 'widget', LANGUAGE_ZONE ),
			'percent'		=> _x( 'Percent', 'widget', LANGUAGE_ZONE ),
			'showPercent'	=> _x( 'Show', 'widget', LANGUAGE_ZONE ),
		) );

	}

endif; // presscore_setup_admin_scripts

add_action( 'admin_enqueue_scripts', 'presscore_setup_admin_scripts', 15 );


if ( ! function_exists( 'presscore_themeoptions_add_share_buttons' ) ) :

	/**
	 * Add some share buttons to theme options.
	 */
	function presscore_themeoptions_add_share_buttons( $buttons ) {
		$theme_soc_buttons = presscore_themeoptions_get_social_buttons_list();
		if ( $theme_soc_buttons && is_array( $theme_soc_buttons ) ) {
			$buttons = array_merge( $buttons, $theme_soc_buttons );
		}
		return $buttons;
	}

endif; // presscore_themeoptions_add_share_buttons

add_filter( 'optionsframework_interface-social_buttons', 'presscore_themeoptions_add_share_buttons', 15 );


if ( ! function_exists( 'presscore_dt_paginator_args_filter' ) ) :

	/**
	 * PressCore dt_paginator args filter.
	 *
	 * @param array $args Paginator args.
	 * @return array Filtered $args.
	 */
	function presscore_dt_paginator_args_filter( $args ) {
		global $post;
		$config = Presscore_Config::get_instance();

		// show all pages in paginator
		$show_all_pages = '0';

		if ( is_page() ) {
			$show_all_pages = $config->get( 'show_all_pages' );
		}

		if ( '0' != $show_all_pages ) {
			$args['num_pages'] = 9999;
		} else {
			$args['num_pages'] = 5;
		}

		$args['wrap'] = '
		<div class="paginator" role="navigation">
			<div class="page-links">%LIST%
		';
		$args['pages_wrap'] = '
			</div>
			<div class="page-nav">
				%PREV%%NEXT%
			</div>
		</div>
		';
		$args['item_wrap'] = '<a href="%HREF%" %CLASS_ACT%>%TEXT%</a>';
		$args['first_wrap'] = '<a href="%HREF%" %CLASS_ACT%>%FIRST_PAGE%</a>';
		$args['last_wrap'] = '<a href="%HREF%" %CLASS_ACT%>%LAST_PAGE%</a>';
		$args['dotleft_wrap'] = '<a href="javascript: void(0);" class="dots">%TEXT%</a>'; 
		$args['dotright_wrap'] = '<a href="javascript: void(0);" class="dots">%TEXT%</a>';// %TEXT%
		$args['pages_prev_class'] = 'nav-prev';
		$args['pages_next_class'] = 'nav-next';
		$args['act_class'] = 'act';
		$args['next_text'] = _x( 'Next page', 'paginator', LANGUAGE_ZONE );
		$args['prev_text'] = _x( 'Prev page', 'paginator', LANGUAGE_ZONE );
		$args['no_next'] = '';
		$args['no_prev'] = '';
		$args['first_is_first_mode'] = true;

		return $args;
	}

endif; // presscore_dt_paginator_args_filter

add_filter( 'dt_paginator_args', 'presscore_dt_paginator_args_filter' );


if ( ! function_exists( 'presscore_comment_id_fields_filter' ) ) :

	/**
	 * PressCore comments fields filter. Add Post Comment and clear links before hudden fields.
	 *
	 * @since presscore 0.1
	 */
	function presscore_comment_id_fields_filter( $result ) {
		$comment_buttons = '<a class="clear-form" href="javascript: void(0);">' . __( 'clear form', LANGUAGE_ZONE ) . '</a>';
		$comment_buttons .= '<a class="dt-btn dt-btn-m" href="javascript: void(0);">' . __('Submit', LANGUAGE_ZONE) . '</a>';

		return $comment_buttons . $result;
	}

endif; // presscore_comment_id_fields_filter

add_filter( 'comment_id_fields', 'presscore_comment_id_fields_filter' );


if ( ! function_exists( 'presscore_comment' ) ) :

	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since presscore 1.0
	 */
	function presscore_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="pingback">
			<div class="pingback-content">
				<span><?php _e( 'Pingback:', LANGUAGE_ZONE ); ?></span>
				<?php comment_author_link(); ?>
				<?php edit_comment_link( __( '(Edit)', LANGUAGE_ZONE ), ' ' ); ?>
			</div>
		<?php
				break;
			default :
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<article id="div-comment-<?php comment_ID(); ?>">

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->

			<div class="comment-meta">
				<time datetime="<?php comment_time( 'c' ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					// TODO: add date/time format (for qTranslate)
					printf( __( '%1$s at %2$s', LANGUAGE_ZONE ), get_comment_date(), get_comment_time() ); ?>
				</time>
				<?php edit_comment_link( __( '(Edit)', LANGUAGE_ZONE ), ' ' ); ?>
			</div><!-- .comment-meta -->

			<div class="comment-author vcard">
				<?php if ( dt_validate_gravatar( $comment->comment_author_email ) ) :	?>
					<?php echo get_avatar( $comment, 60 ); ?>
				<?php else : ?>
					<span class="avatar no-avatar"></span>
				<?php endif; ?>
				<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
			</div><!-- .comment-author .vcard -->

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', LANGUAGE_ZONE ); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-content"><?php comment_text(); ?></div>

			</article>

		<?php
				break;
		endswitch;
	}

endif; // presscore_comment


if ( ! function_exists( 'presscore_body_class' ) ) :

	/**
	 * Add theme speciffik classes to body.
	 *
	 * @since presscore 1.0
	 */
	function presscore_body_class( $classes ) {
		$config = Presscore_Config::get_instance();

		$desc_on_hoover = ( 'on_hoover' == $config->get('description') );

		// template classes
		switch ( $config->get('template') ) {
			case 'blog': $classes[] = 'blog'; break;
			case 'portfolio': $classes[] = 'portfolio'; break;
			case 'team': $classes[] = 'team'; break;
			case 'testimonials': $classes[] = 'testimonials'; break;
			case 'archive': $classes[] = 'archive'; break;
			case 'search': $classes[] = 'search'; break;
			case 'albums': $classes[] = 'albums'; break;
			case 'media': $classes[] = 'media'; break;
		}

		// layout classes
		switch ( $config->get('layout') ) {
			case 'masonry':
				if ( $desc_on_hoover ) {
					$classes[] = 'layout-masonry-grid';
				} else {
					$classes[] = 'layout-masonry';
				}
				break;
			case 'grid':
				$classes[] = 'layout-grid';
				if ( $desc_on_hoover ) {
					$classes[] = 'grid-text-hovers';
				}
				break;
			case 'checkerboard':
			case 'list': $classes[] = 'layout-list'; break;
		}

		// hide dividers if content is off
		if ( in_array($config->get('template'), array('albums', 'portfolio')) && 'masonry' == $config->get('layout') ) {
			$show_dividers = $config->get('show_titles') || $config->get('show_details') || $config->get('show_excerpts') || $config->get('show_terms') || $config->get('show_links');
			if ( !$show_dividers ) $classes[] = 'description-off';
		}

		if ( is_single() ) {
			$post_type = get_post_type();
			if ( 'dt_portfolio' == $post_type && ( post_password_required() || ( !comments_open() && '0' == get_comments_number() ) ) ) {
				$classes[] = 'no-comments';
			}
		}

		if ( in_array('single-dt_portfolio', $classes) ) {
			$key = array_search('single-dt_portfolio', $classes);
			$classes[ $key ] = 'single-portfolio';
		}

		if ( 'overlap' == $config->get('header_background') ) {
			$classes[] = 'overlap';
		}

		if ( 'fancy' == $config->get( 'header_title' ) ) {
			$classes[] = 'fancy-header-on';
		} elseif ( 'slideshow' == $config->get( 'header_title' ) ) {
			$classes[] = 'slideshow-on';

			if ( '3d' == $config->get( 'slideshow_mode' ) && 'fullscreen-content' == $config->get( 'slideshow_3d_layout' ) ) {
				$classes[] = 'threed-fullscreen';
			}

		} elseif ( is_single() && 'disabled' == $config->get( 'header_title' ) ) {
			$classes[] = 'title-off';
		}

		// hoover style
		switch( of_get_option('hoover-style', 'none') ) {
			case 'grayscale': $classes[] = 'filter-grayscale-static'; break;
			case 'gray+color': $classes[] = 'filter-grayscale'; break;
			case 'blur' : $classes[] = 'image-blur'; break;
		}

		// add boxed-class to body
		if ( 'boxed' == of_get_option('general-layout', 'wide') ) {
			$classes[] = 'boxed-layout';
		}

		// transparent header
		if ( 'transparent' == $config->get('header_background') ) {
			$classes[] = 'transparent';
		}

		return array_values( array_unique( $classes ) );
	}

endif; // presscore_body_class

add_filter( 'body_class', 'presscore_body_class' );


if ( ! function_exists( 'presscore_post_types_author_archives' ) ) :

	/**
	 * Add Custom Post Types to Author Archives
	 */
	function presscore_post_types_author_archives( $query ) {
		
		// Add 'videos' post type to author archives
		if ( $query->is_author ) {
			$post_type = $query->get( 'post_type' );
			$query->set( 'post_type', array_merge( (array) $post_type, array('dt_portfolio', 'post') ) );
		}
		
		// Remove the action after it's run
		remove_action( 'pre_get_posts', 'presscore_post_types_author_archives' );
	}

endif; // presscore_post_types_author_archives

add_action( 'pre_get_posts', 'presscore_post_types_author_archives' );


if ( ! function_exists( 'presscore_get_blank_image' ) ) :

	/**
	 * Get blank image.
	 *
	 */
	function presscore_get_blank_image() {
		return PRESSCORE_THEME_URI . '/images/1px.gif';
	}

endif; // presscore_get_blank_image


if ( ! function_exists( 'presscore_get_default_avatar' ) ) :

	/**
	 * Get default avatar.
	 *
	 * @return string.
	 */
	function presscore_get_default_avatar() {
		return PRESSCORE_THEME_URI . '/images/no-avatar.gif';
	}

endif; // presscore_get_default_avatar


if ( !function_exists('presscore_get_default_image') ) :

	/**
	 * Get default image.
	 *
	 * Return array( 'url', 'width', 'height' );
	 *
	 * @return array.
	 */
	function presscore_get_default_image() {
		return array( PRESSCORE_THEME_URI . '/images/noimage.jpg', 1000, 1000 );
	}

endif;


if ( ! function_exists( 'presscore_get_widgetareas_options' ) ) :

	/**
	 * Prepare array with widgetareas options.
	 *
	 */
	function presscore_get_widgetareas_options() {
		$widgetareas_list = array();
		$widgetareas_stored = of_get_option('widgetareas', false);
		if ( is_array($widgetareas_stored) ) {
			foreach ( $widgetareas_stored as $index=>$desc ) {
				$widgetareas_list[ 'sidebar_' . $index ] = $desc['sidebar_name'];
			}
		}

		return $widgetareas_list;
	}

endif; // presscore_get_widgetareas_options


if ( ! function_exists( 'presscore_meta_boxes_get_images_proportions' ) ) :

	/**
	 * Image proportions array.
	 *
	 * @return array.
	 */
	function presscore_meta_boxes_get_images_proportions( $prop = false ) {

		$ratios = array(
			'1'		=> array( 'ratio' => 0.33, 'desc' => '1:3' ),
			'2'		=> array( 'ratio' => 0.3636, 'desc' => '4:11' ),
			'3'		=> array( 'ratio' => 0.45, 'desc' => '9:20' ),
			'4'		=> array( 'ratio' => 0.5625, 'desc' => '9:16' ),
			'5'		=> array( 'ratio' => 0.6, 'desc' => '3:5' ),
			'6'		=> array( 'ratio' => 0.6666, 'desc' => '2:3' ),
			'7'		=> array( 'ratio' => 0.75, 'desc' => '3:4' ),
			'8'		=> array( 'ratio' => 1, 'desc' => '1:1' ),
			'9'		=> array( 'ratio' => 1.33, 'desc' => '4:3' ),
			'10'	=> array( 'ratio' => 1.5, 'desc' => '3:2' ),
			'11'	=> array( 'ratio' => 1.66, 'desc' => '5:3' ),
			'12'	=> array( 'ratio' => 1.77, 'desc' => '16:9' ),
			'13'	=> array( 'ratio' => 2.22, 'desc' => '20:9' ),
			'14'	=> array( 'ratio' => 2.75, 'desc' => '11:4' ),
			'15'	=> array( 'ratio' => 3, 'desc' => '3:1' ),
		);

		if ( false === $prop ) return $ratios;

		if ( isset($ratios[ $prop ]) ) return $ratios[ $prop ]['ratio'];

		return false;
	}

endif; // presscore_meta_boxes_get_images_proportions


if ( ! function_exists( 'presscore_get_social_icons_data' ) ) :

	/**
	 * Return social icons array( 'class', 'title' ).
	 *
	 */
	function presscore_get_social_icons_data() {
		return array(
			'facebook'		=> __('Facebook', LANGUAGE_ZONE),
			'twitter'		=> __('Twitter', LANGUAGE_ZONE),
			'google'		=> __('Google+', LANGUAGE_ZONE),
			'dribbble'		=> __('Dribbble', LANGUAGE_ZONE),
			'you-tube'		=> __('YouTube', LANGUAGE_ZONE),
			'rss'			=> __('Rss', LANGUAGE_ZONE),
			'delicious'		=> __('Delicious', LANGUAGE_ZONE),
			'flickr'		=> __('Flickr', LANGUAGE_ZONE),
			'forrst'		=> __('Forrst', LANGUAGE_ZONE),
			'lastfm'		=> __('Lastfm', LANGUAGE_ZONE),
			'linkedin'		=> __('Linkedin', LANGUAGE_ZONE),
			'vimeo'			=> __('Vimeo', LANGUAGE_ZONE),
			'tumbler'		=> __('Tumblr', LANGUAGE_ZONE),
			'pinterest'		=> __('Pinterest', LANGUAGE_ZONE),
			'devian'		=> __('Deviantart', LANGUAGE_ZONE),
			'skype'			=> __('Skype', LANGUAGE_ZONE),
			'github'		=> __('Github', LANGUAGE_ZONE),
			'instagram'		=> __('Instagram', LANGUAGE_ZONE),
			'stumbleupon'	=> __('Stumbleupon', LANGUAGE_ZONE),
			'behance'		=> __('Behance', LANGUAGE_ZONE),
			'mail'			=> __('Mail', LANGUAGE_ZONE),
			'website'		=> __('Website', LANGUAGE_ZONE),
			'px-500'		=> __('500px', LANGUAGE_ZONE),
			'tripedvisor'	=> __('tripedvisor', LANGUAGE_ZONE),
			'vk'			=> __('vk', LANGUAGE_ZONE),
		);
	}

endif; // presscore_get_social_icons_data


if ( ! function_exists( 'presscore_themeoptions_get_headers_defaults' ) ) :

	/**
	 * Returns headers defaults array.
	 *
	 * @return array.
	 * @since presscore 0.1
	 */
	function presscore_themeoptions_get_headers_defaults() {

		$headers = array(
			'h1'	=> array(
				'desc'	=> _x('H1', 'theme-options', LANGUAGE_ZONE),
				'fs'	=> 44,	// font size
				'ff'	=> '',	// font face
				'lh'	=> 50,	// line height
				'uc'	=> 0,	// upper case
			), 
			'h2'	=> array(
				'desc'	=> _x('H2', 'theme-options', LANGUAGE_ZONE),
				'fs'	=> 26,
				'ff'	=> '',
				'lh'	=> 30,
				'uc'	=> 0
			), 
			'h3'	=> array(
				'desc'	=> _x('H3', 'theme-options', LANGUAGE_ZONE),
				'fs'	=> 22,
				'ff'	=> '',
				'lh'	=> 30,
				'uc'	=> 0
			),
			'h4'	=> array(
				'desc'	=> _x('H4', 'theme-options', LANGUAGE_ZONE),
				'fs'	=> 18,
				'ff'	=> '',
				'lh'	=> 20,
				'uc'	=> 0
			),
			'h5'	=> array(
				'desc'	=> _x('H5', 'theme-options', LANGUAGE_ZONE),
				'fs'	=> 15,
				'ff'	=> '',
				'lh'	=> 20,
				'uc'	=> 0
			),
			'h6'	=> array(
				'desc'	=> _x('H6', 'theme-options', LANGUAGE_ZONE),
				'fs'	=> 12,
				'ff'	=> '',
				'lh'	=> 20,
				'uc'	=> 0
			)
		);

		return $headers;
	}

endif; // presscore_themeoptions_get_headers_defaults


if ( ! function_exists( 'presscore_themeoptions_get_buttons_defaults' ) ) :

	/**
	 * Buttons defaults array.
	 */
	function presscore_themeoptions_get_buttons_defaults() {
		return array(
			's'		=> array(
				'desc'	=> _x('Small buttons', 'theme-options', LANGUAGE_ZONE),
				'ff'	=> '',
				'fs'	=> 12,
				'uc'	=> 0,
				'lh'	=> 21
				),
			'm'	=> array(
				'desc'	=> _x('Medium buttons', 'theme-options', LANGUAGE_ZONE),
				'ff'	=> '',
				'fs'	=> 12,
				'uc'	=> 0,
				'lh'	=> 23
				),
			'l'	=> array(
				'desc'	=> _x('Big buttons', 'theme-options', LANGUAGE_ZONE),
				'ff'	=> '',
				'fs'	=> 14,
				'uc'	=> 0,
				'lh'	=> 32
				)
		);
	}

endif; // presscore_themeoptions_get_buttons_defaults


if ( ! function_exists( 'presscore_themeoptions_get_hoover_options' ) ) :

	/**
	 * Hoover options.
	 */
	function presscore_themeoptions_get_hoover_options() {
		return array(
			'none' => _x('None', 'theme-options', LANGUAGE_ZONE),
			'grayscale' => _x('Grayscale', 'theme-options', LANGUAGE_ZONE),
			'gray+color' => _x('Grayscale with color hovers', 'theme-options', LANGUAGE_ZONE),
			'blur' => _x('Blur', 'theme-options', LANGUAGE_ZONE),
		);
	}

endif; // presscore_themeoptions_get_hoover_options


if ( ! function_exists( 'presscore_themeoptions_get_general_layout_options' ) ) :

	/**
	 * General layout.
	 */
	function presscore_themeoptions_get_general_layout_options() {
		return array(
			'wide'	=> _x('Wide', 'theme-options', LANGUAGE_ZONE),
			'boxed'	=> _x('Boxed', 'theme-options', LANGUAGE_ZONE)
		);
	}

endif; // presscore_themeoptions_get_general_layout_options


if ( ! function_exists( 'presscore_themeoptions_get_social_buttons_list' ) ) :

	/**
	 * Social buttons.
	 */
	function presscore_themeoptions_get_social_buttons_list() {
		return array(
			'facebook' 	=> __('Facebook', LANGUAGE_ZONE),
			'twitter' 	=> __('Twitter', LANGUAGE_ZONE),
			'google+' 	=> __('Google+', LANGUAGE_ZONE),
			'pinterest' => __('Pinterest', LANGUAGE_ZONE),
		);
	}

endif; // presscore_themeoptions_get_social_buttons_list


if ( ! function_exists( 'presscore_themeoptions_get_template_list' ) ) :

	/**
	 * Templates list.
	 */
	function presscore_themeoptions_get_template_list(){
		return array(
			'post' 				=> _x('Social buttons in blog posts', 'theme-options', LANGUAGE_ZONE),
			'portfolio_post' 	=> _x('Social buttons in portfolio projects', 'theme-options', LANGUAGE_ZONE),
			'photo' 			=> _x('Social buttons in media (photos and videos)', 'theme-options', LANGUAGE_ZONE),
			'page' 				=> _x('Social buttons on page', 'theme-options', LANGUAGE_ZONE),
		);
	}

endif; // presscore_themeoptions_get_template_list


if ( ! function_exists( 'presscore_themeoptions_get_stripes_list' ) ) :

	/**
	 * Stripes list.
	 */
	function presscore_themeoptions_get_stripes_list() {
		return array(
			1 => array(
				'title'				=> _x('Stripe 1', 'theme-options', LANGUAGE_ZONE),

				'bg_color'			=> '#222526',
				'bg_opacity'		=> 100,
				'bg_color_ie'		=> '#222526',
				'bg_img'			=> array(
					'image'			=> '',
					'repeat'		=> 'repeat',
					'position_x'	=> 'center',
					'position_y'	=> 'center'
				),
				'bg_fullscreen'		=> false,

				'text_color'		=> '#828282',
				'text_header_color'	=> '#ffffff',

				'div_color'		=> '#828282',
				'div_opacity'		=> 100,
				'div_color_ie'		=> '#828282',

				'addit_color'		=> '#dcdcdb',
				'addit_opacity'		=> 100,
				'addit_color_ie'	=> '#dcdcdb',
			),
			2 => array(
				'title'				=> _x('Stripe 2', 'theme-options', LANGUAGE_ZONE),

				'bg_color'			=> '#aeaeae',
				'bg_opacity'		=> 100,
				'bg_color_ie'		=> '#aeaeae',
				'bg_img'			=> array(
					'image'			=> '',
					'repeat'		=> 'repeat',
					'position_x'	=> 'center',
					'position_y'	=> 'center'
				),
				'bg_fullscreen'		=> false,

				'text_color'		=> '#828282',
				'text_header_color'	=> '#ffffff',

				'div_color'		=> '#dcdcdb',
				'div_opacity'		=> 100,
				'div_color_ie'		=> '#dcdcdb',

				'addit_color'		=> '#dcdcdb',
				'addit_opacity'		=> 100,
				'addit_color_ie'	=> '#dcdcdb',
			),
			3 => array(
				'title'				=> _x('Stripe 3', 'theme-options', LANGUAGE_ZONE),

				'bg_color'			=> '#cacaca',
				'bg_opacity'		=> 100,
				'bg_color_ie'		=> '#cacaca',
				'bg_img'			=> array(
					'image'			=> '',
					'repeat'		=> 'repeat',
					'position_x'	=> 'center',
					'position_y'	=> 'center'
				),
				'bg_fullscreen'		=> false,

				'text_color'		=> '#828282',
				'text_header_color'	=> '#ffffff',

				'div_color'		=> '#dcdcdb',
				'div_opacity'		=> 100,
				'div_color_ie'		=> '#dcdcdb',

				'addit_color'		=> '#dcdcdb',
				'addit_opacity'		=> 100,
				'addit_color_ie'	=> '#dcdcdb',
			),
		);
	}

endif; // presscore_themeoptions_get_stripes_list


if ( ! function_exists( 'presscore_get_team_links_array' ) ) :

	/**
	 * Return links list for team post meta box.
	 *
	 * @return array.
	 */
	function presscore_get_team_links_array() {
		$team_links =  array(
			'website'		=> array( 'desc' => _x( 'Personal blog / website', 'team link', LANGUAGE_ZONE ) ),
			'mail'			=> array( 'desc' => _x( 'E-mail', 'team link', LANGUAGE_ZONE ) ),
		);

		$common_links = presscore_get_social_icons_data();
		if ( $common_links ) {

			foreach ( $common_links as $key=>$value ) {

				if ( isset($team_links[ $key ]) ) {
					continue;
				}

				$team_links[ $key ] = array( 'desc' => $value );
			}
		}

		return $team_links;
	}

endif; // presscore_get_team_links_array


// ! Initialising Visual Composer
if (!class_exists('WPBakeryVisualComposerAbstract')) {
	$dir = dirname(__FILE__) . '/wpbakery/';

	global $composer_settings;
	$composer_settings = Array(
		'APP_ROOT'      => $dir . '/js_composer',
		'WP_ROOT'       => dirname( dirname( dirname( dirname($dir ) ) ) ). '/',
		'APP_DIR'       => basename( $dir ) . '/js_composer/',
		'CONFIG'        => $dir . '/js_composer/config/',
		'ASSETS_DIR'    => 'assets/',
		'COMPOSER'      => $dir . '/js_composer/composer/',
		'COMPOSER_LIB'  => $dir . '/js_composer/composer/lib/',
		'SHORTCODES_LIB'  => $dir . '/js_composer/composer/lib/shortcodes/',
		'USER_DIR_NAME'  => 'inc/shortcodes/vc_templates', /* Path relative to your current theme, where VC should look for new shortcode templates */

		//for which content types Visual Composer should be enabled by default
		'default_post_types' => Array('page', 'post', 'dt_portfolio', 'dt_testimonials', 'dt_team', 'dt_benefits')
	);

	require_once locate_template('/wpbakery/js_composer/js_composer.php');
	$wpVC_setup->init($composer_settings);
}

// Initialising Shortcodes
if (class_exists('WPBakeryVisualComposerAbstract')) {

	require_once locate_template('/inc/shortcodes/vc-extensions.php');

	require_once locate_template('/inc/shortcodes/js_composer_bridge.php');

	if ( ! function_exists( 'js_composer_bridge_admin' ) ) {
		function js_composer_bridge_admin( $hook ) {
			// presscore stuff
			wp_enqueue_style( '', get_template_directory_uri() . '/inc/shortcodes/css/js_composer_bridge.css' );
		}
	}

	add_action( 'admin_enqueue_scripts', 'js_composer_bridge_admin', 15 );
}