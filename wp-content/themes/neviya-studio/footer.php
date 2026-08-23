<?php
/**
 * Site footer.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="neviya-site-footer" role="contentinfo">
	<div class="neviya-site-footer__inner">
		<p class="neviya-site-footer__brand"><?php bloginfo( 'name' ); ?></p>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav aria-label="<?php esc_attr_e( 'תפריט פוטר', 'neviya-studio' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'neviya-footer-menu',
					'depth'          => 1,
				) );
				?>
			</nav>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="neviya-site-footer__widgets">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		<?php endif; ?>

		<p class="neviya-site-footer__copy">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
			<?php esc_html_e( 'כל הזכויות שמורות.', 'neviya-studio' ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
