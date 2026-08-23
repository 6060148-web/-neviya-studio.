<?php
/**
 * Shared section renderers.
 *
 * Every chapter of the scroll story lives in exactly one function here.
 * front-page.php, the [neviya_*] shortcodes and every Elementor widget
 * all call into these functions instead of duplicating markup, so the
 * theme-only experience and the Elementor-edited experience never drift
 * apart. Elementor widgets only translate their controls into $args.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Chapter 1 — Hero: "הנביעה הראשונה".
 */
function neviya_render_hero_section( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'eyebrow'  => __( 'סטודיו נביעה — עיצוב ושיווק גרפי ודיגיטלי', 'neviya-studio' ),
		'title'    => __( 'מרעיון קטן נובעת שפה שלמה', 'neviya-studio' ),
		'subtitle' => __( 'אנחנו נותנים לרעיונות צורה, צבע ותנועה: מיתוג, קמפיינים וחוויות דיגיטליות שנוצרו כדי להרגיש.', 'neviya-studio' ),
		'cue'      => __( 'גללו כדי לצפות ברעיון נובע לחיים', 'neviya-studio' ),
	) );
	?>
	<section id="neviya-hero" class="neviya-hero" data-neviya-scene="hero" aria-label="<?php esc_attr_e( 'פתיחה: הנביעה הראשונה', 'neviya-studio' ); ?>">
		<div class="neviya-hero__sticky">
			<div class="neviya-hero__art">
				<?php get_template_part( 'template-parts/art-hero' ); ?>
			</div>
			<div class="neviya-hero__content">
				<p class="neviya-hero__eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
				<h1 class="neviya-hero__title"><?php echo wp_kses_post( $args['title'] ); ?></h1>
				<p class="neviya-hero__subtitle"><?php echo esc_html( $args['subtitle'] ); ?></p>
			</div>
			<div class="neviya-scroll-cue">
				<span><?php echo esc_html( $args['cue'] ); ?></span>
				<svg viewBox="0 0 24 40" aria-hidden="true"><path d="M12 2 V34 M5 27 L12 34 L19 27" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Chapter 2 — About: "על הסטודיו – מהרעיון לצורה".
 */
function neviya_render_about_section( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title' => __( 'על הסטודיו — מהרעיון לצורה', 'neviya-studio' ),
		'lines' => array(
			__( 'כל פרויקט מתחיל באותו מקום: קו דק, מחשבה לא גמורה, רעיון שעוד לא יודע איך הוא נראה.', 'neviya-studio' ),
			__( 'אנחנו בסטודיו נביעה מלווים אותו מהסקיצה הראשונה ועד לשפה חזותית שלמה — מיתוג, קמפיין, אתר או סרטון.', 'neviya-studio' ),
			__( 'לא מייצרים תבניות. מקשיבים לרעיון, ונותנים לו לנבוע לצורה שמתאימה רק לו.', 'neviya-studio' ),
		),
	) );
	?>
	<section id="neviya-about" class="neviya-about" data-neviya-scene="about" aria-labelledby="neviya-about-title">
		<div class="neviya-about__line-art"><?php get_template_part( 'template-parts/art-about' ); ?></div>
		<div class="neviya-about__inner">
			<h2 id="neviya-about-title" class="neviya-section-title"><?php echo esc_html( $args['title'] ); ?></h2>
			<div class="neviya-about__lines">
				<?php foreach ( $args['lines'] as $i => $line ) : ?>
					<p class="neviya-about__line" style="--line-index: <?php echo (int) $i; ?>;"><?php echo esc_html( $line ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Chapter 3 — Domains: "תחומי היצירה".
 */
function neviya_render_domains_section( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title' => __( 'תחומי היצירה', 'neviya-studio' ),
	) );

	$terms = get_terms( array(
		'taxonomy'   => 'neviya_project_category',
		'hide_empty' => false,
	) );
	if ( ! is_array( $terms ) || is_wp_error( $terms ) ) {
		$terms = array();
	}

	$order = array_keys( neviya_default_project_categories() );
	usort( $terms, function ( $a, $b ) use ( $order ) {
		$pa = array_search( $a->slug, $order, true );
		$pb = array_search( $b->slug, $order, true );
		return ( false === $pa ? 999 : $pa ) <=> ( false === $pb ? 999 : $pb );
	} );
	?>
	<section id="neviya-domains" class="neviya-domains" data-neviya-scene="domains" aria-labelledby="neviya-domains-title">
		<h2 id="neviya-domains-title" class="neviya-section-title"><?php echo esc_html( $args['title'] ); ?></h2>
		<svg class="neviya-domains__stem" viewBox="0 0 100 1000" preserveAspectRatio="none" aria-hidden="true">
			<path class="neviya-draw-path" pathLength="1" d="M50,0 C 20,140 80,280 50,420 C 20,560 80,700 50,840 C 30,900 60,960 50,1000" fill="none" stroke="#8a8378" stroke-width="1.4" stroke-dasharray="1 7" stroke-linecap="round"></path>
		</svg>
		<ul class="neviya-domains__list">
			<?php foreach ( $terms as $i => $term ) : ?>
				<li class="neviya-domains__item neviya-domains__item--<?php echo 0 === $i % 2 ? 'right' : 'left'; ?>">
					<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="neviya-domains__link">
						<span class="neviya-domains__glyph" style="color:var(--neviya-accent-<?php echo esc_attr( ( $i % 4 ) + 1 ); ?>);"><?php echo neviya_domain_icon( $term->slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed, trusted inline SVG set. ?></span>
						<span class="neviya-domains__label"><?php echo esc_html( $term->name ); ?></span>
						<span class="neviya-domains__arrow" aria-hidden="true">←</span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php
}

/**
 * Chapter 4 — Projects: "פרויקטים נבחרים".
 */
function neviya_render_projects_section( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'    => __( 'פרויקטים נבחרים', 'neviya-studio' ),
		'category' => '',
		'featured' => true,
		'count'    => 6,
	) );

	$query = neviya_get_projects_query( array(
		'category' => $args['category'],
		'featured' => $args['featured'],
		'count'    => $args['count'],
	) );

	if ( ! $query->have_posts() && $args['featured'] ) {
		$query = neviya_get_projects_query( array(
			'category' => $args['category'],
			'featured' => false,
			'count'    => $args['count'],
		) );
	}
	?>
	<section id="neviya-projects" class="neviya-projects" data-neviya-scene="projects" aria-labelledby="neviya-projects-title">
		<h2 id="neviya-projects-title" class="neviya-section-title"><?php echo esc_html( $args['title'] ); ?></h2>

		<?php if ( ! $query->have_posts() ) : ?>
			<p class="neviya-projects__empty"><?php esc_html_e( 'עדיין אין פרויקטים פורסמו. הוסיפו פרויקט ראשון דרך פרויקטים ← הוסף פרויקט.', 'neviya-studio' ); ?></p>
		<?php else : ?>
			<div class="neviya-projects__list">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					get_template_part( 'template-parts/project-card', null, array( 'project' => neviya_get_project_data( get_the_ID() ) ) );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php endif; ?>
	</section>
	<?php
}

/**
 * Chapter 5 — Contact: "בואו ניצור משהו שנובע".
 */
function neviya_render_contact_section( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'    => __( 'בואו ניצור משהו שנובע', 'neviya-studio' ),
		'subtitle' => __( 'יש לכם רעיון שמחכה לנבוע? ספרו לנו עליו — נשמח לחשוב יחד איך הוא הופך לשפה חזותית.', 'neviya-studio' ),
		'email'    => get_theme_mod( 'neviya_contact_email', 'hello@neviya-studio.co.il' ),
		'phone'    => get_theme_mod( 'neviya_contact_phone', '050-0000000' ),
	) );
	get_template_part( 'template-parts/contact', null, $args );
}
