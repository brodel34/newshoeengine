<?php
/**
 * Prequelle Menu item custom fields example
 *
 * @package Menu_Item_Custom_Fields
 * @version 0.1.0
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 * @see https://github.com/kucrut/wp-menu-item-custom-fields
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Sample menu item metadata
 *
 * This class demonstrate the usage of Menu Item Custom Fields in plugins/themes.
 *
 * @since 0.1.0
 */
class Prequelle_Menu_Item_Custom_Fields {

	/**
	 * Initialize plugin
	 */
	public static function init() {
		require get_parent_theme_file_path( '/inc/admin/menu/class-menu-item-custom-fields.php' );
		add_action( 'menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 3 );
		add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
		add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );
	}

	/**
	 * Save custom field value
	 *
	 * @wp_hook action wp_update_nav_menu_item
	 *
	 * @param int   $menu_id         Nav menu ID
	 * @param int   $menu_item_db_id Menu item ID
	 * @param array $menu_item_args  Menu item data
	 */
	public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {

		$meta_keys = array(
			'_menu-item-icon',
			'_menu-item-icon-position',
			'_mega-menu',
			'_mega-menu-tagline',
			'_menu-item-hidden',
			'_menu-item-button-style',
			'_menu-item-button-style-primary',
			'_menu-item-button-style-secondary',
			'_menu-item-new',
			'_menu-item-hot',
			'_menu-item-sale',
			'_mega-menu-cols',
			'_menu-item-not-linked',
			'_menu-item-scroll',
			'_menu-item-external',
			'_menu-item-background',
			'_menu-item-background-repeat',
			'_sub-menu-skin'
		);

		foreach ( $meta_keys as $meta_key ) {

			/* Sanitize */
			if ( ! empty( $_POST[ $meta_key ][ $menu_item_db_id ] ) ) {
				$value = esc_attr( $_POST[ $meta_key ][ $menu_item_db_id ] );

			} else {

				$value = '';
			}

			/* Update */
			if ( ! empty( $value ) ) {

				update_post_meta( $menu_item_db_id, $meta_key, $value );

			} else {
				delete_post_meta( $menu_item_db_id, $meta_key );
			}
		}
	}

	/**
	 * Print field
	 *
	 * @param object $item  Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args  Menu item args.
	 * @param int    $id    Nav menu ID.
	 *
	 * @return string Form fields
	 */
	public static function _fields( $item, $depth, $args = array(), $id = 0 ) {
			$item_id = $item->ID;
		?>
			<p class="field-_mega-menu description description-wide">
				<label for="edit-_mega-menu-<?php echo esc_attr( $item_id ) ?>">
					<input name="_mega-menu[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_mega-menu', true ), 'on' ); ?>>
					<?php esc_html_e( 'Mega Menu (only available for first level items)', 'prequelle' ) ?>
				</label>
			</p>

			<p class="field-_menu-item-not-linked description description-wide">
				<label for="edit-_menu-item-not-linked-<?php echo esc_attr( $item_id ) ?>">
					<input name="_menu-item-not-linked[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-not-linked', true ), 'on' ); ?>>
					<?php esc_html_e( 'Mega Menu 2nd level or dropdown item', 'prequelle' ) ?>
				</label>
			</p>

			<p class="field-_menu-item-hidden description description-wide">
				<label for="edit-_menu-item-hidden-<?php echo esc_attr( $item_id ) ?>">
					<input name="_menu-item-hidden[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-hidden', true ), 'on' ); ?>>
					<?php esc_html_e( 'Hide item on mega menu (for mega menu 2nd level only)', 'prequelle' ) ?>
				</label>
			</p>

			<p class="field-_menu-item-button-style description description-wide">
				<label for="edit-_menu-item-button-style-<?php echo esc_attr( $item_id ) ?>">
					<select name="_menu-item-button-style[<?php echo esc_attr( $item_id ); ?>]">
						<option value=""><?php esc_html_e( 'None', 'prequelle' ); ?></option>
						<option value="primary" <?php selected( get_post_meta( $item_id, '_menu-item-button-style', true ), 'primary' ); ?>><?php esc_html_e( 'Primary', 'prequelle' ); ?></option>
						<option value="secondary" <?php selected( get_post_meta( $item_id, '_menu-item-button-style', true ), 'secondary' ); ?>><?php esc_html_e( 'Secondary', 'prequelle' ); ?></option>
					</select>
					<?php esc_html_e( 'Button Style (only available for first level items)', 'prequelle' ) ?>
				</label>
			</p>
			<p class="field-_menu-item-new description description-wide">
				<label for="edit-_menu-item-new-<?php echo esc_attr( $item_id ) ?>">
					<input name="_menu-item-new[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-new', true ), 'on' ); ?>>
					<?php esc_html_e( 'New', 'prequelle' ) ?>
				</label>
			</p>
			<p class="field-_menu-item-hot description description-wide">
				<label for="edit-_menu-item-hot-<?php echo esc_attr( $item_id ) ?>">
					<input name="_menu-item-hot[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-hot', true ), 'on' ); ?>>
					<?php esc_html_e( 'Hot', 'prequelle' ) ?>
				</label>
			</p>
			<p class="field-_menu-item-sale description description-wide">
				<label for="edit-_menu-item-sale-<?php echo esc_attr( $item_id ) ?>">
					<input name="_menu-item-sale[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-sale', true ), 'on' ); ?>>
					<?php esc_html_e( 'Sale', 'prequelle' ) ?>
				</label>
			</p>
			<p class="field-_menu-item-scroll description description-wide">
				<label for="edit-_menu-item-scroll-<?php echo esc_attr( $item_id ) ?>">
					<input name="_menu-item-scroll[<?php echo esc_attr( $item_id ); ?>]" value="on" type="checkbox" <?php checked( get_post_meta( $item_id, '_menu-item-scroll', true ), 'on' ); ?>>
					<?php esc_html_e( 'Scroll to an anchor', 'prequelle' ) ?>
				</label>
			</p>
			<p class="field-_mega-menu-cols description description-wide">
					<label for="edit-_mega-menu-cols-<?php echo esc_attr( $item_id ) ?>"><?php esc_html_e( 'Mega Menu Columns', 'prequelle' ) ?></label>
						<br>
						<select name="_mega-menu-cols[<?php echo esc_attr( $item_id ); ?>]">
							<option value="4" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 4 ); ?>>4</option>
							<option value="5" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 5 ); ?>>5</option>
							<option value="3" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 3 ); ?>>3</option>
							<option value="2" <?php selected( get_post_meta( $item_id, '_mega-menu-cols', true ), 2 ); ?>>2</option>
						</select>
				</p>
			<p class="field-_mega-menu-tagline description description-wide">
				<label for="edit-_mega-menu-tagline-<?php echo esc_attr( $item_id ) ?>">
					<input type="text" name="_mega-menu-tagline[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( get_post_meta( $item_id, '_mega-menu-tagline', true ) ); ?>">
				</label><br>
				<?php esc_html_e( 'Optional Mega Menu Tagline (only available for first level items)', 'prequelle' ) ?>
			</p>
			<?php if ( function_exists( 'wvc_get_fontawesome_icons' ) ) : ?>
				<?php
					$wvc_icons = wvc_get_fontawesome_icons();
				?>
				<p class="field-custom description description-wide prequelle-searchable-container">
					<label for="edit-_menu-item-icon-<?php echo esc_attr( $item_id ) ?>"><?php esc_html_e( 'Icon', 'prequelle' ) ?></label><br />
						<span><?php printf(
							'<select data-placeholder="%1$s" name="_menu-item-icon[%2$d]" class="prequelle-searchable edit-_menu-item-icon" id="edit-_menu-item-icon-%2$d">',
							esc_html__( 'None', 'prequelle' ),
							$item_id
						);
						echo '<option value="">' . esc_html__( 'None', 'prequelle' ) . '</option>';
						foreach ( $wvc_icons as $key => $value ) {
							echo '<option value="' . esc_attr( $key ) . '"';
							selected( esc_attr( get_post_meta( $item_id, '_menu-item-icon', true ) ), $key );
							echo ">$value</option>";
						}
						echo '</select>'
						?></span>
				</p>

				<p class="field-_menu-item-icon-position description description-wide">
					<label for="edit-_menu-item-icon-position-<?php echo esc_attr( $item_id ) ?>"><?php esc_html_e( 'Icon position', 'prequelle' ) ?></label>
						<br>
						<select name="_menu-item-icon-position[<?php echo esc_attr( $item_id ); ?>]">
							<option value="before" <?php selected( get_post_meta( $item_id, '_menu-item-icon-position', true ), 'before' ); ?>><?php esc_html_e( 'before', 'prequelle' ); ?></option>
							<option value="after" <?php selected( get_post_meta( $item_id, '_menu-item-icon-position', true ), 'after' ); ?>><?php esc_html_e( 'after', 'prequelle' ); ?></option>
						</select>
				</p>
			<?php endif; ?>
		<?php
	}

	/**
	 * Add our field to the screen options toggle
	 *
	 * To make this work, the field wrapper must have the class 'field-custom'
	 *
	 * @param array $columns Menu item columns
	 * @return array
	 */
	public static function _columns( $columns ) {

		return $columns;
	}
}
Prequelle_Menu_Item_Custom_Fields::init();
