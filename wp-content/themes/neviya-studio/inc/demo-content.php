<?php
/**
 * One-click demo content: six realistic Hebrew sample projects covering
 * all five creative domains and all five scroll-reveal styles, each
 * with a generated placeholder cover image (via GD) so the story never
 * shows a broken <img>. Purely an admin convenience — safe to skip.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function neviya_demo_admin_page() {
	add_submenu_page(
		'edit.php?post_type=neviya_project',
		__( 'תוכן לדוגמה', 'neviya-studio' ),
		__( 'תוכן לדוגמה', 'neviya-studio' ),
		'manage_options',
		'neviya-demo-content',
		'neviya_render_demo_admin_page'
	);
}
add_action( 'admin_menu', 'neviya_demo_admin_page' );

function neviya_render_demo_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$existing = get_posts( array(
		'post_type'      => 'neviya_project',
		'meta_key'       => '_neviya_demo',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	) );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'תוכן לדוגמה — סטודיו נביעה', 'neviya-studio' ); ?></h1>
		<p><?php esc_html_e( 'יוצר שישה פרויקטים לדוגמה (אחד לפחות בכל תחום יצירה), עם תמונות Cover גנריות שנוצרות אוטומטית ותוכן בעברית. שימושי לבדיקת התבנית לפני העלאת עבודות אמיתיות.', 'neviya-studio' ); ?></p>
		<?php if ( $existing ) : ?>
			<p><strong><?php printf( esc_html__( 'נמצאו %d פרויקטי דוגמה קיימים. יצירה מחדש תמחק אותם ותיצור עדכניים.', 'neviya-studio' ), count( $existing ) ); ?></strong></p>
		<?php endif; ?>
		<form method="post">
			<?php wp_nonce_field( 'neviya_import_demo' ); ?>
			<input type="hidden" name="neviya_action" value="import_demo" />
			<?php submit_button( __( 'צור / רענן פרויקטי דוגמה', 'neviya-studio' ) ); ?>
		</form>
		<?php if ( $existing ) : ?>
			<form method="post">
				<?php wp_nonce_field( 'neviya_import_demo' ); ?>
				<input type="hidden" name="neviya_action" value="delete_demo" />
				<?php submit_button( __( 'מחיקת פרויקטי דוגמה', 'neviya-studio' ), 'delete' ); ?>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

function neviya_handle_demo_actions() {
	if ( empty( $_POST['neviya_action'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'neviya_import_demo' );

	if ( 'import_demo' === $_POST['neviya_action'] ) {
		neviya_delete_demo_projects();
		neviya_create_demo_projects();
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'פרויקטי הדוגמה נוצרו בהצלחה.', 'neviya-studio' ) . '</p></div>';
		} );
	} elseif ( 'delete_demo' === $_POST['neviya_action'] ) {
		neviya_delete_demo_projects();
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'פרויקטי הדוגמה נמחקו.', 'neviya-studio' ) . '</p></div>';
		} );
	}
}
add_action( 'admin_init', 'neviya_handle_demo_actions' );

function neviya_delete_demo_projects() {
	$ids = get_posts( array(
		'post_type'      => 'neviya_project',
		'meta_key'       => '_neviya_demo',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	) );
	foreach ( $ids as $id ) {
		$thumb_id = get_post_thumbnail_id( $id );
		wp_delete_post( $id, true );
		if ( $thumb_id ) {
			wp_delete_attachment( $thumb_id, true );
		}
	}
}

/**
 * Generate a simple, tasteful placeholder cover (solid gradient-ish
 * fill + the project initial) so demo projects never ship a broken image.
 */
function neviya_generate_placeholder_image( $title, $hex_color ) {
	if ( ! function_exists( 'imagecreatetruecolor' ) ) {
		return 0;
	}

	$width  = 1200;
	$height = 750;
	$image  = imagecreatetruecolor( $width, $height );

	$hex = ltrim( $hex_color, '#' );
	$r   = hexdec( substr( $hex, 0, 2 ) );
	$g   = hexdec( substr( $hex, 2, 2 ) );
	$b   = hexdec( substr( $hex, 4, 2 ) );

	$bg = imagecolorallocate( $image, (int) ( $r * 0.18 + 250 * 0.82 ), (int) ( $g * 0.18 + 247 * 0.82 ), (int) ( $b * 0.18 + 240 * 0.82 ) );
	imagefill( $image, 0, 0, $bg );

	$accent = imagecolorallocate( $image, $r, $g, $b );
	imagefilledellipse( $image, (int) ( $width * 0.72 ), (int) ( $height * 0.32 ), 520, 520, $accent );

	$upload_dir = wp_upload_dir();
	$filename   = 'neviya-demo-' . sanitize_title( $title ) . '-' . wp_generate_password( 4, false ) . '.jpg';
	$filepath   = trailingslashit( $upload_dir['path'] ) . $filename;
	imagejpeg( $image, $filepath, 88 );
	imagedestroy( $image );

	$filetype = wp_check_filetype( $filename, null );
	$attachment = array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => $title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	$attach_id = wp_insert_attachment( $attachment, $filepath );
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$attach_data = wp_generate_attachment_metadata( $attach_id, $filepath );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	update_post_meta( $attach_id, '_wp_attachment_image_alt', $title );

	return $attach_id;
}

function neviya_demo_projects_data() {
	return array(
		array(
			'title'    => 'להב — מיתוג למשרד עורכי דין',
			'category' => 'branding-campaigns',
			'reveal'   => 'mask',
			'color'    => '#c85c46',
			'client'   => 'משרד להב ושות׳',
			'year'     => '2024',
			'services' => "מיתוג\nשפה גרפית\nניירת משרדית",
			'excerpt'  => 'זהות ויזואלית חדה ובוטחת למשרד עורכי דין מוביל — מהלוגו ועד תיק העבודה.',
			'content'  => 'ליוינו את המשרד ממיתוג ישן ומפוזר לשפה אחידה ומדויקת. התהליך התחיל בסקיצות עיפרון פשוטות שבדקו איך "יציבות" יכולה להיראות בקו אחד, והמשיך לפלטת צבע חמה שמאזנת בין רצינות מקצועית לחום אנושי.',
		),
		array(
			'title'    => 'עלה — סימן מסחרי לרשת בתי קפה',
			'category' => 'logos-visual-language',
			'reveal'   => 'logo',
			'color'    => '#7a9b6e',
			'client'   => 'עלה קפה',
			'year'     => '2023',
			'services' => "עיצוב לוגו\nשפה גרפית\nאריזות",
			'excerpt'  => 'מעבר מסקיצה בוטנית פשוטה לסמל שנצרב על כל כוס קפה ברשת.',
			'content'  => 'הרעיון נולד מקו יחיד שמייצג עלה נובט. בדקנו עשרות גרסאות ביד לפני שהגענו לצורה הסופית — כזו שעובדת גם כטאבו קטן על כוס נייר וגם כשלט חוצות.',
		),
		array(
			'title'    => 'קמפיין "נביעה של רעיונות" — מודעות דיגיטל',
			'category' => 'digital-ads',
			'reveal'   => 'paper',
			'color'    => '#d98a4a',
			'client'   => 'חממת סטארטאפים עירונית',
			'year'     => '2024',
			'services' => "קריאייטיב\nעיצוב מודעות\nניהול קמפיין",
			'excerpt'  => 'סדרת מודעות לרשתות חברתיות שהביאה לעלייה של פי שלושה בהרשמות לתוכנית.',
			'content'  => 'כל מודעה בסדרה מספרת שלב אחר במסע של רעיון — מסקיצה על מפית ועד מוצר גמור. השפה החזותית האחידה יצרה זיהוי מיידי גם כשהמודעות התחלפו כל שבוע.',
		),
		array(
			'title'    => 'סרטון השקה — קולקציית "מים ואדמה"',
			'category' => 'video-motion',
			'reveal'   => 'video',
			'color'    => '#4f7f9e',
			'client'   => 'סטודיו קרמיקה נטע',
			'year'     => '2023',
			'services' => "תסריט\nצילום\nמושן גרפיקה",
			'excerpt'  => 'סרטון קצר שמלווה כלי קרמיקה מהחומר הגולמי ועד המדף — בקצב רגוע ואנושי.',
			'video'    => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
			'content'  => 'צילמנו את התהליך כולו באור טבעי, והוספנו שכבת מושן גרפיקה עדינה שמזכירה קווי מתאר של סקיצה — כדי לשמור על התחושה היד־עשויה גם במסך.',
		),
		array(
			'title'    => 'אתר תדמית — סטודיו אדריכלות קו פתוח',
			'category' => 'websites-landing-pages',
			'reveal'   => 'browser',
			'color'    => '#4f7f9e',
			'client'   => 'קו פתוח אדריכלים',
			'year'     => '2024',
			'services' => "עיצוב UX/UI\nבניית אתר\nאופטימיזציה למובייל",
			'excerpt'  => 'אתר תדמית מינימליסטי שנותן לתמונות הפרויקטים להוביל, בלי רעש חזותי מיותר.',
			'external' => 'https://example.com',
			'content'  => 'המבנה שקוף ופשוט: כל פרויקט מקבל עמוד נושם משלו. השקענו הרבה בביצועים כדי שגם בגלריות תמונה עשירות האתר יטען מהר בנייד.',
		),
		array(
			'title'    => 'דף נחיתה — השקת קורס עיצוב דיגיטלי',
			'category' => 'websites-landing-pages',
			'reveal'   => 'mask',
			'color'    => '#6fa8a3',
			'client'   => 'אקדמיית יוצרים',
			'year'     => '2022',
			'services' => "קופירייטינג\nעיצוב\nבניית עמוד נחיתה",
			'excerpt'  => 'דף נחיתה ממוקד המרות שהוביל להרשמה מלאה למחזור הראשון תוך שבועיים.',
			'content'  => 'התמקדנו במסר אחד ברור ובקריאה לפעולה שחוזרת בעדינות לאורך הדף, בלי להרגיש אגרסיבית.',
		),
	);
}

function neviya_create_demo_projects() {
	$order = 0;
	foreach ( neviya_demo_projects_data() as $data ) {
		$post_id = wp_insert_post( array(
			'post_type'    => 'neviya_project',
			'post_status'  => 'publish',
			'post_title'   => $data['title'],
			'post_excerpt' => $data['excerpt'],
			'post_content' => $data['content'],
			'menu_order'   => $order,
		) );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		wp_set_object_terms( $post_id, array( $data['category'] ), 'neviya_project_category' );

		$thumb_id = neviya_generate_placeholder_image( $data['title'], $data['color'] );
		if ( $thumb_id ) {
			set_post_thumbnail( $post_id, $thumb_id );
		}

		update_post_meta( $post_id, '_neviya_demo', '1' );
		update_post_meta( $post_id, '_neviya_client', $data['client'] );
		update_post_meta( $post_id, '_neviya_year', $data['year'] );
		update_post_meta( $post_id, '_neviya_services', $data['services'] );
		update_post_meta( $post_id, '_neviya_lead_color', $data['color'] );
		update_post_meta( $post_id, '_neviya_reveal_style', $data['reveal'] );
		update_post_meta( $post_id, '_neviya_button_text', __( 'לצפייה בפרויקט', 'neviya-studio' ) );
		update_post_meta( $post_id, '_neviya_is_featured', $order < 4 ? '1' : '0' );
		if ( ! empty( $data['video'] ) ) {
			update_post_meta( $post_id, '_neviya_video_url', $data['video'] );
		}
		if ( ! empty( $data['external'] ) ) {
			update_post_meta( $post_id, '_neviya_external_url', $data['external'] );
		}

		$order++;
	}
}
