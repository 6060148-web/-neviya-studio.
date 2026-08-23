<?php
/**
 * Default template for standard pages (e.g. privacy policy).
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="neviya-page">
		<header class="neviya-page__header">
			<h1 class="neviya-section-title"><?php the_title(); ?></h1>
		</header>
		<div class="neviya-page__content">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
