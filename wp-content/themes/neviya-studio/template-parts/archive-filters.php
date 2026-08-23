<?php
/**
 * Category filter pills shared by the project archive and taxonomy templates.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_slug = is_tax( 'neviya_project_category' ) ? get_queried_object()->slug : '';
$terms        = get_terms( array( 'taxonomy' => 'neviya_project_category', 'hide_empty' => false ) );
if ( ! is_array( $terms ) || is_wp_error( $terms ) ) {
	return;
}
?>
<nav class="neviya-archive-filters" aria-label="<?php esc_attr_e( 'סינון פרויקטים לפי תחום', 'neviya-studio' ); ?>">
	<a href="<?php echo esc_url( get_post_type_archive_link( 'neviya_project' ) ); ?>" class="neviya-archive-filters__item <?php echo '' === $current_slug ? 'is-active' : ''; ?>">
		<?php esc_html_e( 'הכל', 'neviya-studio' ); ?>
	</a>
	<?php foreach ( $terms as $term ) : ?>
		<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="neviya-archive-filters__item <?php echo $current_slug === $term->slug ? 'is-active' : ''; ?>">
			<?php echo esc_html( $term->name ); ?>
		</a>
	<?php endforeach; ?>
</nav>
