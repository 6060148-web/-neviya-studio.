<?php
/**
 * Core theme supports, menus, image sizes.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup: supports, menus, text domain, image sizes.
 */
function neviya_theme_setup() {
	load_theme_textdomain( 'neviya-studio', NEVIYA_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus( array(
		'primary' => __( 'תפריט ראשי', 'neviya-studio' ),
		'footer'  => __( 'תפריט פוטר', 'neviya-studio' ),
	) );

	add_image_size( 'neviya-cover', 1600, 1000, true );
	add_image_size( 'neviya-cover-small', 800, 500, true );
	add_image_size( 'neviya-gallery', 1200, 1200, false );

	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 1400;
	}
}
add_action( 'after_setup_theme', 'neviya_theme_setup' );

/**
 * Force RTL text direction attribute regardless of admin language,
 * since the studio's public site is Hebrew/RTL-only by design.
 */
function neviya_force_html_dir( $output ) {
	return 'rtl';
}
add_filter( 'language_attributes', function ( $output ) {
	if ( strpos( $output, 'dir=' ) === false ) {
		$output .= ' dir="rtl"';
	}
	return $output;
} );

/**
 * Register the widget areas used by the footer.
 */
function neviya_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'פוטר', 'neviya-studio' ),
		'id'            => 'footer-1',
		'description'   => __( 'אזור ווידג\'טים בתחתית האתר', 'neviya-studio' ),
		'before_widget' => '<div class="neviya-footer-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="neviya-footer-widget__title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'neviya_widgets_init' );
