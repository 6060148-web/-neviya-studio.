<?php
/**
 * Custom Post Type: neviya_project + its category taxonomy.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function neviya_register_project_cpt() {
	$labels = array(
		'name'                  => __( 'פרויקטים', 'neviya-studio' ),
		'singular_name'         => __( 'פרויקט', 'neviya-studio' ),
		'menu_name'             => __( 'פרויקטים – נביעה', 'neviya-studio' ),
		'add_new'               => __( 'הוסף פרויקט', 'neviya-studio' ),
		'add_new_item'          => __( 'הוספת פרויקט חדש', 'neviya-studio' ),
		'edit_item'             => __( 'עריכת פרויקט', 'neviya-studio' ),
		'new_item'              => __( 'פרויקט חדש', 'neviya-studio' ),
		'view_item'             => __( 'צפייה בפרויקט', 'neviya-studio' ),
		'view_items'            => __( 'צפייה בפרויקטים', 'neviya-studio' ),
		'search_items'          => __( 'חיפוש פרויקטים', 'neviya-studio' ),
		'not_found'             => __( 'לא נמצאו פרויקטים', 'neviya-studio' ),
		'not_found_in_trash'    => __( 'לא נמצאו פרויקטים באשפה', 'neviya-studio' ),
		'all_items'             => __( 'כל הפרויקטים', 'neviya-studio' ),
		'featured_image'        => __( 'תמונת Cover', 'neviya-studio' ),
		'set_featured_image'    => __( 'קביעת תמונת Cover', 'neviya-studio' ),
		'remove_featured_image' => __( 'הסרת תמונת Cover', 'neviya-studio' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'show_in_rest'       => true,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-art',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'projects', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => 'projects',
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
		'template'           => array(),
	);

	register_post_type( 'neviya_project', $args );

	$tax_labels = array(
		'name'              => __( 'תחומי יצירה', 'neviya-studio' ),
		'singular_name'     => __( 'תחום יצירה', 'neviya-studio' ),
		'search_items'      => __( 'חיפוש תחומים', 'neviya-studio' ),
		'all_items'         => __( 'כל התחומים', 'neviya-studio' ),
		'edit_item'         => __( 'עריכת תחום', 'neviya-studio' ),
		'update_item'       => __( 'עדכון תחום', 'neviya-studio' ),
		'add_new_item'      => __( 'הוספת תחום חדש', 'neviya-studio' ),
		'new_item_name'     => __( 'שם תחום חדש', 'neviya-studio' ),
		'menu_name'         => __( 'תחומי יצירה', 'neviya-studio' ),
	);

	register_taxonomy( 'neviya_project_category', 'neviya_project', array(
		'labels'            => $tax_labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'project-category', 'with_front' => false ),
	) );
}
add_action( 'init', 'neviya_register_project_cpt' );

/**
 * The five default creative domains, keyed by a stable slug so re-running
 * this never duplicates terms even if labels are later translated.
 */
function neviya_default_project_categories() {
	return array(
		'branding-campaigns' => __( 'קמפיינים ומיתוג', 'neviya-studio' ),
		'logos-visual-language' => __( 'לוגואים ושפה גרפית', 'neviya-studio' ),
		'digital-ads' => __( 'מודעות ועיצוב לדיגיטל', 'neviya-studio' ),
		'video-motion' => __( 'וידאו ומושן', 'neviya-studio' ),
		'websites-landing-pages' => __( 'אתרים ודפי נחיתה', 'neviya-studio' ),
	);
}

/**
 * Seed the five default categories on theme activation only, never on
 * every load, so editors are free to rename/remove them afterwards.
 */
function neviya_seed_default_terms() {
	foreach ( neviya_default_project_categories() as $slug => $name ) {
		if ( ! term_exists( $slug, 'neviya_project_category' ) ) {
			wp_insert_term( $name, 'neviya_project_category', array( 'slug' => $slug ) );
		}
	}
}

function neviya_on_activation() {
	neviya_register_project_cpt();
	neviya_seed_default_terms();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'neviya_on_activation' );
