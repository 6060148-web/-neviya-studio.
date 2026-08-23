<?php
/**
 * Site header.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#FFF7F0" />
	<?php if ( is_singular( 'neviya_project' ) ) : ?>
		<meta name="description" content="<?php echo esc_attr( wp_strip_all_tags( get_the_excerpt() ) ); ?>" />
	<?php elseif ( is_front_page() ) : ?>
		<meta name="description" content="<?php esc_attr_e( 'סטודיו נביעה – עיצוב ושיווק גרפי ודיגיטלי. ממיתוג ועד וידאו ומושן, אנחנו נותנים לרעיונות צורה, צבע ותנועה.', 'neviya-studio' ); ?>" />
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="neviya-skip-link screen-reader-text" href="#neviya-main"><?php esc_html_e( 'דלג לתוכן הראשי', 'neviya-studio' ); ?></a>

<header class="neviya-site-header" role="banner">
	<div class="neviya-site-header__inner">
		<a class="neviya-site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span><?php bloginfo( 'name' ); ?></span>
			<?php endif; ?>
		</a>
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="neviya-site-header__nav" aria-label="<?php esc_attr_e( 'תפריט ראשי', 'neviya-studio' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'neviya-nav-menu',
					'depth'          => 1,
				) );
				?>
			</nav>
		<?php endif; ?>
	</div>
</header>

<main id="neviya-main" role="main">
