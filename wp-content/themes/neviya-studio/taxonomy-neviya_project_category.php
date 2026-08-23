<?php
/**
 * Archive of projects filtered to one creative domain.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
$term = get_queried_object();
?>
<div class="neviya-archive">
	<header class="neviya-archive__header">
		<h1 class="neviya-section-title"><?php echo esc_html( $term->name ); ?></h1>
		<?php if ( $term->description ) : ?>
			<p class="neviya-archive__description"><?php echo esc_html( $term->description ); ?></p>
		<?php endif; ?>
	</header>

	<?php get_template_part( 'template-parts/archive-filters' ); ?>

	<?php if ( have_posts() ) : ?>
		<div class="neviya-archive__grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/project-card', null, array( 'project' => neviya_get_project_data( get_the_ID() ) ) );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'עדיין אין פרויקטים בתחום הזה.', 'neviya-studio' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
