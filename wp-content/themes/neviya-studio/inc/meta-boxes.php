<?php
/**
 * Native post-meta fields for neviya_project – no ACF required.
 *
 * All keys are also readable as Elementor Dynamic Tags via the
 * "Post Meta" dynamic tag using the exact meta_key below, and via
 * the neviya_get_project_meta() helper in inc/helpers.php.
 *
 * @package Neviya_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Central registry of every project meta field: key, label, type, sanitizer.
 * Single source of truth used by the metabox render, the save handler and
 * the front-end helpers, so a field only ever needs to be added once.
 */
function neviya_project_meta_fields() {
	return array(
		'_neviya_client'         => array(
			'label' => __( 'לקוח', 'neviya-studio' ),
			'type'  => 'text',
		),
		'_neviya_year'           => array(
			'label' => __( 'שנה', 'neviya-studio' ),
			'type'  => 'text',
		),
		'_neviya_services'       => array(
			'label' => __( 'שירותים שניתנו (שורה לכל שירות)', 'neviya-studio' ),
			'type'  => 'textarea',
		),
		'_neviya_lead_color'     => array(
			'label'   => __( 'צבע מוביל של הפרויקט', 'neviya-studio' ),
			'type'    => 'color',
			'default' => '#C85C46',
		),
		'_neviya_video_url'      => array(
			'label' => __( 'כתובת וידאו (YouTube / Vimeo / קובץ mp4)', 'neviya-studio' ),
			'type'  => 'url',
		),
		'_neviya_external_url'   => array(
			'label' => __( 'קישור לאתר / פרויקט חיצוני', 'neviya-studio' ),
			'type'  => 'url',
		),
		'_neviya_button_text'    => array(
			'label'   => __( 'טקסט לכפתור', 'neviya-studio' ),
			'type'    => 'text',
			'default' => __( 'לצפייה בפרויקט', 'neviya-studio' ),
		),
		'_neviya_is_featured'    => array(
			'label' => __( 'פרויקט נבחר (יוצג בעמוד הבית)', 'neviya-studio' ),
			'type'  => 'checkbox',
		),
		'_neviya_reveal_style'   => array(
			'label'   => __( 'סגנון חשיפה בגלילה', 'neviya-studio' ),
			'type'    => 'select',
			'options' => array(
				'mask'    => __( 'מסכת עיפרון (ברירת מחדל)', 'neviya-studio' ),
				'paper'   => __( 'שכבת נייר מחליקה', 'neviya-studio' ),
				'video'   => __( 'תצוגת וידאו', 'neviya-studio' ),
				'browser' => __( 'מסגרת דפדפן', 'neviya-studio' ),
				'logo'    => __( 'מעבר מסקיצה לסמל', 'neviya-studio' ),
			),
			'default' => 'mask',
		),
		'_neviya_sketch_image_id' => array(
			'label' => __( 'תמונת סקיצה (עיפרון, אופציונלי)', 'neviya-studio' ),
			'type'  => 'image',
		),
		'_neviya_color_image_id'  => array(
			'label' => __( 'תמונה צבעונית (אופציונלי)', 'neviya-studio' ),
			'type'  => 'image',
		),
		'_neviya_gallery_ids'     => array(
			'label' => __( 'גלריית תמונות', 'neviya-studio' ),
			'type'  => 'gallery',
		),
	);
}

function neviya_add_project_meta_boxes() {
	add_meta_box(
		'neviya_project_details',
		__( 'פרטי הפרויקט', 'neviya-studio' ),
		'neviya_render_project_meta_box',
		'neviya_project',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'neviya_add_project_meta_boxes' );

function neviya_render_project_meta_box( $post ) {
	wp_nonce_field( 'neviya_save_project_meta', 'neviya_project_meta_nonce' );
	$fields = neviya_project_meta_fields();
	?>
	<div class="neviya-metabox">
		<p class="description">
			<?php esc_html_e( 'שדות אלה זמינים גם כ-Dynamic Tags בתוך Elementor (Post Meta) לפי מפתח השדה.', 'neviya-studio' ); ?>
		</p>
		<table class="form-table neviya-metabox__table">
			<tbody>
			<?php foreach ( $fields as $key => $field ) :
				$value = get_post_meta( $post->ID, $key, true );
				if ( '' === $value && isset( $field['default'] ) ) {
					$value = $field['default'];
				}
				?>
				<tr>
					<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
					<td>
						<?php neviya_render_meta_field( $key, $field, $value, $post->ID ); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

function neviya_render_meta_field( $key, $field, $value, $post_id ) {
	switch ( $field['type'] ) {
		case 'textarea':
			printf(
				'<textarea id="%1$s" name="%1$s" rows="4" class="large-text">%2$s</textarea>',
				esc_attr( $key ),
				esc_textarea( $value )
			);
			break;

		case 'select':
			echo '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">';
			foreach ( $field['options'] as $option_key => $option_label ) {
				printf(
					'<option value="%1$s" %2$s>%3$s</option>',
					esc_attr( $option_key ),
					selected( $value, $option_key, false ),
					esc_html( $option_label )
				);
			}
			echo '</select>';
			break;

		case 'checkbox':
			printf(
				'<label><input type="checkbox" id="%1$s" name="%1$s" value="1" %2$s /> %3$s</label>',
				esc_attr( $key ),
				checked( $value, '1', false ),
				esc_html__( 'הפעל', 'neviya-studio' )
			);
			break;

		case 'color':
			printf(
				'<input type="text" id="%1$s" name="%1$s" value="%2$s" class="neviya-color-field" data-default-color="%3$s" />',
				esc_attr( $key ),
				esc_attr( $value ),
				esc_attr( $field['default'] ?? '' )
			);
			break;

		case 'url':
			printf(
				'<input type="url" id="%1$s" name="%1$s" value="%2$s" class="large-text" placeholder="https://" />',
				esc_attr( $key ),
				esc_attr( $value )
			);
			break;

		case 'image':
			$image_id  = absint( $value );
			$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
			?>
			<div class="neviya-image-field" data-target="<?php echo esc_attr( $key ); ?>">
				<input type="hidden" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $image_id ); ?>" />
				<div class="neviya-image-field__preview">
					<?php if ( $image_url ) : ?>
						<img src="<?php echo esc_url( $image_url ); ?>" alt="" style="max-width:160px;height:auto;display:block;" />
					<?php endif; ?>
				</div>
				<button type="button" class="button neviya-image-field__select"><?php esc_html_e( 'בחירת תמונה', 'neviya-studio' ); ?></button>
				<button type="button" class="button neviya-image-field__remove" <?php echo $image_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'הסרה', 'neviya-studio' ); ?></button>
			</div>
			<?php
			break;

		case 'gallery':
			$ids = $value ? array_filter( array_map( 'absint', explode( ',', $value ) ) ) : array();
			?>
			<div class="neviya-gallery-field">
				<input type="hidden" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>" />
				<ul class="neviya-gallery-field__list">
					<?php foreach ( $ids as $id ) :
						$thumb = wp_get_attachment_image_url( $id, 'thumbnail' );
						if ( ! $thumb ) {
							continue;
						}
						?>
						<li data-id="<?php echo esc_attr( $id ); ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="" /><button type="button" class="neviya-gallery-field__remove-item" aria-label="<?php esc_attr_e( 'הסר תמונה', 'neviya-studio' ); ?>">&times;</button></li>
					<?php endforeach; ?>
				</ul>
				<button type="button" class="button neviya-gallery-field__select"><?php esc_html_e( 'הוספת תמונות לגלריה', 'neviya-studio' ); ?></button>
			</div>
			<?php
			break;

		default:
			printf(
				'<input type="text" id="%1$s" name="%1$s" value="%2$s" class="regular-text" />',
				esc_attr( $key ),
				esc_attr( $value )
			);
	}
}

function neviya_save_project_meta( $post_id ) {
	if ( ! isset( $_POST['neviya_project_meta_nonce'] ) ||
		! wp_verify_nonce( wp_unslash( $_POST['neviya_project_meta_nonce'] ), 'neviya_save_project_meta' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( 'neviya_project' !== get_post_type( $post_id ) ) {
		return;
	}

	$fields = neviya_project_meta_fields();

	foreach ( $fields as $key => $field ) {
		if ( 'checkbox' === $field['type'] ) {
			$value = isset( $_POST[ $key ] ) ? '1' : '0';
			update_post_meta( $post_id, $key, $value );
			continue;
		}

		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$raw = wp_unslash( $_POST[ $key ] );

		switch ( $field['type'] ) {
			case 'textarea':
				$clean = sanitize_textarea_field( $raw );
				break;
			case 'url':
				$clean = esc_url_raw( $raw );
				break;
			case 'color':
				$clean = sanitize_hex_color( $raw );
				break;
			case 'select':
				$clean = array_key_exists( $raw, $field['options'] ) ? $raw : $field['default'];
				break;
			case 'image':
				$clean = absint( $raw );
				break;
			case 'gallery':
				$ids   = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
				$clean = implode( ',', $ids );
				break;
			default:
				$clean = sanitize_text_field( $raw );
		}

		update_post_meta( $post_id, $key, $clean );
	}
}
add_action( 'save_post', 'neviya_save_project_meta' );

/**
 * Enqueue the media uploader + color picker only on the project editor.
 */
function neviya_metabox_assets( $hook ) {
	global $post_type;
	if ( 'neviya_project' !== $post_type || ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'neviya-admin-metabox', NEVIYA_URI . '/assets/js/admin-metabox.js', array( 'jquery', 'wp-color-picker' ), NEVIYA_VERSION, true );
	wp_localize_script( 'neviya-admin-metabox', 'neviyaAdminMetabox', array(
		'chooseImage'   => __( 'בחירת תמונה', 'neviya-studio' ),
		'addToGallery'  => __( 'הוספת תמונות לגלריה', 'neviya-studio' ),
		'removeImage'   => __( 'הסר תמונה', 'neviya-studio' ),
	) );
	wp_enqueue_style( 'neviya-admin-metabox', NEVIYA_URI . '/assets/css/admin-metabox.css', array(), NEVIYA_VERSION );
}
add_action( 'admin_enqueue_scripts', 'neviya_metabox_assets' );
