<?php
/**
 * Fallback template (required for a valid WordPress theme).
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="neviya-archive">
	<?php if ( have_posts() ) : ?>
		<div class="neviya-archive__grid neviya-archive__grid--blog">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'neviya-blog-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'neviya-cover-small', array( 'loading' => 'lazy' ) ); ?></a>
					<?php endif; ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p><?php the_excerpt(); ?></p>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'לא נמצא תוכן.', 'neviya-studio' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
