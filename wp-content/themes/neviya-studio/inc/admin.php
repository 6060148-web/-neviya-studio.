<?php
/**
 * Admin-side polish: project list columns and a first-run notice.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function neviya_project_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['neviya_cover']    = __( 'Cover', 'neviya-studio' );
			$new['neviya_category'] = __( 'תחום', 'neviya-studio' );
			$new['neviya_featured'] = __( 'נבחר', 'neviya-studio' );
		}
	}
	return $new;
}
add_filter( 'manage_neviya_project_posts_columns', 'neviya_project_columns' );

function neviya_project_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'neviya_cover':
			$thumb = get_the_post_thumbnail( $post_id, array( 60, 60 ) );
			echo $thumb ? $thumb : '—';
			break;
		case 'neviya_category':
			$terms = get_the_terms( $post_id, 'neviya_project_category' );
			if ( is_array( $terms ) && ! empty( $terms ) ) {
				echo esc_html( implode( ', ', wp_list_pluck( $terms, 'name' ) ) );
			} else {
				echo '—';
			}
			break;
		case 'neviya_featured':
			echo '1' === get_post_meta( $post_id, '_neviya_is_featured', true )
				? '<span class="dashicons dashicons-star-filled" style="color:#c85c46;"></span>'
				: '—';
			break;
	}
}
add_action( 'manage_neviya_project_posts_custom_column', 'neviya_project_column_content', 10, 2 );

/**
 * Nudge new admins toward Settings → Reading if the front page isn't
 * yet set to the story template, since that's the single most common
 * setup mistake with this theme.
 */
function neviya_admin_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'dashboard' !== $screen->id ) {
		return;
	}
	$show_on_front = get_option( 'show_on_front' );
	$page_on_front = (int) get_option( 'page_on_front' );
	$has_template  = $page_on_front && 'template-story.php' === get_page_template_slug( $page_on_front );

	if ( 'page' === $show_on_front && $has_template ) {
		return;
	}
	?>
	<div class="notice notice-info">
		<p>
			<strong><?php esc_html_e( 'סטודיו נביעה:', 'neviya-studio' ); ?></strong>
			<?php esc_html_e( 'כדי שסצנת הגלילה תופיע בעמוד הבית, צרו עמוד, שייכו לו את התבנית "מסע גלילה – נביעה" ובחרו אותו כעמוד הבית תחת הגדרות ← קריאה. לחלופין, עמוד הבית פועל אוטומטית גם בלי הגדרה, בעזרת front-page.php.', 'neviya-studio' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'neviya_admin_setup_notice' );
