<?php
/**
 * Qusq Lite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Qusq_Lite
 */

if ( ! function_exists( 'qusq_lite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function qusq_lite_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Qusq Lite, use a find and replace
		 * to change 'qusq-lite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'qusq-lite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'qusq-lite' ),
			'social'  => esc_html__( 'Social Links', 'qusq-lite' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom logo feature.
		add_theme_support( 'custom-logo', array(
			'height'      => 55,
			'width'       => 47,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title-text' ),
		) );
	}
endif;
add_action( 'after_setup_theme', 'qusq_lite_setup' );



/**
 * Display / hide title text and tagline text based on customizer setting.
 */
function qusq_lite_header_text_style() {

	$show = (bool) get_theme_mod( 'header_text', true );

	$custom_css = '
                .site-title-text,
				.ish-tagline-text {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}';

	if ( ! $show ) {
		wp_add_inline_style( 'qusq-lite-style', $custom_css );
	}

}
add_action( 'wp_enqueue_scripts', 'qusq_lite_header_text_style', 11 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function qusq_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'qusq_lite_content_width', 980 );
}
add_action( 'after_setup_theme', 'qusq_lite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function qusq_lite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'qusq-lite' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'qusq-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s ish-widget-element">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'qusq_lite_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function qusq_lite_scripts() {
	wp_enqueue_style( 'qusq-lite-style', get_stylesheet_uri(), array(), '20151215' );

	// custom slider script by Matus
    wp_enqueue_script( 'custom-slider', get_stylesheet_directory_uri() . '/dist/custom-slider-minified.js', array( 'jquery' ),'',true );

    wp_enqueue_script( 'qusq-lite-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'qusq-lite-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/bower/modernizr/modernizr.js', array(), '20151215', true );

	wp_enqueue_script( 'lightgallery', get_template_directory_uri() . '/js/bower/lightgallery/dist/js/lightgallery-all.min.js', array( 'jquery' ), '20151215', true );
	wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/js/bower/lightgallery/dist/css/lightgallery.min.css', array(), '20151215' );

	wp_enqueue_script( 'isinviewport', get_template_directory_uri() . '/js/bower/isInViewport/lib/isInViewport.min.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'macy', get_template_directory_uri() . '/js/bower/macy/dist/macy.min.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'qusq-lite-animonscroll', get_template_directory_uri() . '/js/AnimOnScroll.js', array( 'jquery', 'imagesloaded' ), '20151215', true );

	wp_enqueue_script( 'qusq-lite-main', get_template_directory_uri() . '/js/main.js', array( 'jquery', 'imagesloaded' ), '20151215', true );

	wp_enqueue_style( 'qusq-lite-fonts', urldecode( qusq_lite_google_fonts_url() ), array(), '20151215' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'qusq_lite_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Module for Dynamic CSS Generation
 */
require get_template_directory() . '/inc/mu-modules/dynamic-css-enabler/dynamic-css-enabler.php';

/**
 * Module for Better Customizer handling
 */
require get_template_directory() . '/inc/mu-modules/customizer-enhancement/customizer-enhancement.php';

/**
 * Module to enable Customizer promo section
 */
require get_template_directory() . '/inc/mu-modules/customizer-promo-section/class-qusq-customize.php';

/**
 * Module for TinyMCE editor styles
 */
require get_template_directory() . '/inc/modules/editor-style/editor-style.php';

/**
 * Module to enable usage of metaboxes
 */
require get_template_directory() . '/inc/modules/metabox-enabler/metabox-enabler.php';

/**
 * Module to add Color Settings to customizer
 */
require get_template_directory() . '/inc/modules/customizer-colors/customizer-colors.php';

/**
 * Module to add Blog Sidebar Setting to customizer
 */
require get_template_directory() . '/inc/modules/customizer-blog-sidebar/customizer-blog-sidebar.php';

/**
 * Module to add Smooth Scroll Setting to customizer
 */
require get_template_directory() . '/inc/modules/customizer-smooth-scroll/customizer-smooth-scroll.php';

/**
 * Module to add Metabox to pick the user for "About Page" template
 */
require get_template_directory() . '/inc/modules/metabox-about-user/metabox-about-user.php';

/**
 * Module to enable the essential JetPack Modules
 */
require get_template_directory() . '/inc/modules/jetpack-modules-enabler/jetpack-modules-enabler.php';

/**
 * Module to enable TGM plugin activation
 */
require get_template_directory() . '/inc/modules/tgm-plugin-activation/tgm-plugin-activation.php';

/**
 * Module to enable Theme Dashboard
 */
require get_template_directory() . '/inc/mu-modules/qusq-dashboard/class-qusq-dashboard.php';

/**
 * Module to enable Subscribe Pop Up
 */
require get_template_directory() . '/inc/modules/subscribe-popup/subscribe-popup.php';

function my_pagination_rewrite() {
    add_rewrite_rule('blog/page/?([0-9]{1,})/?$', 'index.php?category_name=blog&paged=$matches[1]', 'top');
}
add_action('init', 'my_pagination_rewrite');