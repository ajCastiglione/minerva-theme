<?php
/**
 * Main functions file for the theme
 *
 * @package minervawebdevelopment
 * @author Antonio Castiglione
 * @link https://minervawebdevelopment.com
 */

// LOAD BONES CORE (if you remove this, the theme will break).
require_once 'library/bones.php';

// CUSTOMIZE THE WordPress ADMIN (off by default).
require_once 'library/admin.php';

/**
 * LAUNCH BONES
 * Let's get everything up and running.
 */
function bones_ahoy() {
	 // Allow editor style.
	add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

	// launching operation cleanup.
	add_action( 'init', 'bones_head_cleanup' );
	// A better title.
	add_filter( 'wp_title', 'rw_title', 10, 3 );
	// remove WP version from RSS.
	add_filter( 'the_generator', 'bones_rss_version' );
	// remove pesky injected css for recent comments widget.
	add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head.
	add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
	// clean up gallery output in wp.
	add_filter( 'gallery_style', 'bones_gallery_style' );

	// enqueue base scripts and styles.
	add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );

	// launching this stuff after theme setup.
	bones_theme_support();

	// adding sidebars to WordPress (these are created in functions.php).
	add_action( 'widgets_init', 'bones_register_sidebars' );

	// cleaning up random code around images.
	add_filter( 'the_content', 'bones_filter_ptags_on_images' );
	// cleaning up excerpt.
	add_filter( 'excerpt_more', 'bones_excerpt_more' );

	// Adding full-width blocks in editor support.
	add_theme_support( 'align-wide' );

	// Removing bloat for emojis and such.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
} /* end bones ahoy */

// let's get this party started.
add_action( 'after_setup_theme', 'bones_ahoy' );

/**
 * Pagi
 */

require_once get_template_directory() . '/theme/pagination.php';

/**
 * Navigation
 */
require_once get_template_directory() . '/theme/navigation.php';

/**
 * LOGIN PAGE STYLES
 */
function my_admin_theme_style() {
	wp_enqueue_style( 'my-admin-theme', get_stylesheet_directory_uri() . '/library/css/login.css', null, '1.2' );
}
add_action( 'admin_enqueue_scripts', 'my_admin_theme_style' );
add_action( 'login_enqueue_scripts', 'my_admin_theme_style' );

/**
 * Customize the login page url
 *
 * @param string $url The login page url for the developer.
 */
function dev_url( $url ) {
	return 'https://minervawebdevelopment.com';
}
add_filter( 'login_headerurl', 'dev_url' );

/**
 * OEMBED SIZE OPTIONS
 */
if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/**
 * THEME CUSTOMIZE
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bones_theme_customizer( $wp_customize ) {
	// $wp_customize calls go here.
	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

// sepreated customizer options by panels into thier own files.
require 'library/customizer/panels/external-libraries.php';

/**
 * ACTIVE SIDEBARS
 */
require_once get_template_directory() . '/theme/sidebars.php';

/**
 * COMMENT LAYOUT
 */
require_once get_template_directory() . '/theme/comments.php';

/**
 * UTILITIES/HELPERS
 */
require_once get_template_directory() . '/theme/utils.php';

/**
 * Custom Post Types
 */

/**
 *  Custom Taxonomies
 */

/**
 * ACF Deps
 */
if ( function_exists( 'ACF' ) ) {
	require_once get_template_directory() . '/theme/acf.php';
}
