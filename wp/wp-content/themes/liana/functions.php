<?php

/**
 * Liana functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package liana
 */




//////////////////////////////////////////////////////////////////
// Theme set up
//////////////////////////////////////////////////////////////////

if ( ! function_exists( 'liana_theme_setup' ) ) :

	function liana_theme_setup() {

	// Localization support
		load_theme_textdomain( 'liana', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

	// Title Tag
		add_theme_support( 'title-tag' );

	// Register navigation menu
		register_nav_menus( 
			array(
				'main-menu' 		=> esc_html__( 'Primary Menu','liana' )
			) );


	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

    // Custom logo

   $liana_custom_logo_defaults = array(
        'width'  => '200',
        'height' => '120'
    );
    add_theme_support( 'custom-logo', $liana_custom_logo_defaults );		

   		

	// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'liana_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

   

	// Post Formats
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

	// Post thumbnails
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'liana-post-thumbnails', 1140, 600, TRUE );
		add_image_size( 'liana-related-image', 590, 390, TRUE );
		add_image_size('liana-thumb', 60, 60, TRUE);

	}
endif; // liana_theme_setup

add_action( 'after_setup_theme', 'liana_theme_setup' );



//////////////////////////////////////////////////////////////////
// Set Content Width
//////////////////////////////////////////////////////////////////

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */


function liana_content_width() {
	$content_width = $GLOBALS['content_width'] = 740;
	// Get layout.
	$page_layout = get_theme_mod( 'liana_page_layout' );

	if ( $page_layout == 'full' ) {	
		$content_width = 740;
	}
	else{
		$content_width = 640;
	}
	
	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'blog-sidebar' ) ) {
		$content_width = 740;
	}
	
	$GLOBALS['content_width'] = apply_filters( 'liana_content_width', $content_width );
}
add_action( 'after_setup_theme', 'liana_content_width', 0 );


//////////////////////////////////////////////////////////////////
// Register widget
//////////////////////////////////////////////////////////////////

if ( function_exists('register_sidebar') ) {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'liana' ),
		'id'            => 'blog-sidebar',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'liana' ),
		'id'            => 'footer-widget',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget col-md-3 footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}


/**
 * Registers an editor stylesheet for the theme.
 */
function liana_add_editor_styles() {
	add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'liana_add_editor_styles' );



//////////////////////////////////////////////////////////////////
// Enqueue scripts and styles.
//////////////////////////////////////////////////////////////////

function liana_all_scripts_and_css() {
	
	// CSS File
	wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '3.3.6', 'all');
	wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '4.4.0', 'all');
	wp_enqueue_style('slicknav-css', get_template_directory_uri() . '/assets/css/slicknav.css', array(), NULL);
	wp_enqueue_style( 'liana-stylesheet', get_stylesheet_uri() );
	wp_enqueue_style('liana-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), NULL);

	// Google Fonts
	wp_enqueue_style( 'liana-font-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,300,700,600', array(), NULL );
	wp_enqueue_style( 'liana-font-poppins', '//fonts.googleapis.com/css?family=Lora:400,700', array(), NULL );

	// JS Files
	wp_enqueue_script( 'jquery-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.6', TRUE );
	wp_enqueue_script( 'jquery-slicknav', get_template_directory_uri() . '/assets/js/jquery.slicknav.js', array('jquery'), NULL, TRUE );
	wp_enqueue_script( 'jquery-fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array('jquery'), '1.1', TRUE );
	wp_enqueue_script( 'liana-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), NULL, TRUE );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'liana_all_scripts_and_css' );





//////////////////////////////////////////////////////////////////
// Include files
//////////////////////////////////////////////////////////////////

// Theme Customizer
include('functions/customizer/sanitization-callbacks.php');
include('functions/customizer/customizer_settings.php');
include('functions/customizer/color_customize.php');


//Custom Widgets 
require_once get_template_directory()  . '/inc/widgets/social-icons.php';
require_once get_template_directory()  . '/inc/widgets/about_widget.php';

// Custom template tags for this theme.
require_once get_template_directory() . '/inc/template-tags.php';




