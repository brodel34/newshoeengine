<?php
/**
 * Show 30 days activation notice
 */
function wvc_show_activation_notice() {

	global $pagenow;

	$theme_slug = apply_filters( 'wolftheme_theme_slug', esc_attr( sanitize_title_with_dashes( get_template() ) ) );

	if ( isset( $_GET['page'] ) && $_GET['page'] === $theme_slug . '-about' ) {
		return;
	}

	if ( 'index.php' !== $pagenow ) {
		return;
	}

	if ( get_option( 'wvc_activated' ) ) {
		return;
	}

	$wp_theme = wp_get_theme( get_template() );
	$theme_name = $wp_theme->Name;
	$timeout = wvc_get_transient_timeout( 'wvc_activation_notice' );

	echo '<div class="notice notice-info">
		<p>' . sprintf(
			wp_kses_post( __( 'Hey there, thanks a lot for using our awesome <strong>%s</strong> theme! To ensure that it will work for verified customers only, you just need to enter your <a href="%s" target="_blank" title="Find your purchase code">theme purchase code</a> within the next <strong>%d days</strong>. You won\'t have to activate anything else after that.', 'wolf-visual-composer' ) ),
				$theme_name,
				'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Can-I-Find-my-Purchase-Code-',
				$timeout
			) . '</p>
			<p>
			<a class="button button-primary" href="' . esc_url( admin_url( 'themes.php?page=' . $theme_slug . '-about#license' ) ) . '">' . esc_html( 'Activate', 'wolf-visual-composer' ) . '</a>

			<a class="button button-secondary" target="_blank" href="https://wolfthemes.ticksy.com/article/13268/">' . esc_html( 'More infos', 'wolf-visual-composer' ) . '</a>
		</p>
	</div>';
}

/**
 * Show notice if your plugin is activated but WPBakery Page Builder is not
 */
function wvc_show_vc_missing_notice() {
	$plugin_data = get_plugin_data( __FILE__ );
	echo '<div class="notice notice-warning">
		<p>' . sprintf(
			wp_kses_post( __( '<strong>%s</strong> requires <strong><a href="%s" target="_blank">%s</a></strong> plugin to be installed.', 'wolf-visual-composer' ) ),
				$plugin_data['Name'],
				'https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=wolf-themes',
				'WPBakery Page Builder'
			) . '</p>
	</div>';
}

/**
 * Show notice if your plugin is activated but WPBakery Page Builder is not
 */
function wvc_activation_notice() {

	$theme_slug = apply_filters( 'wolftheme_theme_slug', esc_attr( sanitize_title_with_dashes( get_template() ) ) );

	if ( isset( $_GET['page'] ) && $_GET['page'] === $theme_slug . '-about' ) {
		return;
	}
	echo '<div class="notice notice-warning">
		<p>' . sprintf(
			wp_kses_post( __( '<strong>%s</strong> only works for verified customers who purchased a theme from the <a href="%s" target="_blank">%s</a> team. Please enter your theme <a href="%s" target="_blank" title="Find your purchase code">purchase code</a> in the plugin settings to unlock all features.', 'wolf-visual-composer' ) ),
				'Wolf WPBakery Page Builder Extension',
				'https://wlfthm.es/tf',
				'WolfThemes',
				'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Can-I-Find-my-Purchase-Code-'
			) . '</p>
		<p>
			<a class="button button-primary" href="' . esc_url( admin_url( 'themes.php?page=' . $theme_slug . '-about#license' ) ) . '">' . esc_html( 'Activate', 'wolf-visual-composer' ) . '</a>
		</p>
		</div>';
}

/**
 * Show notice if your plugin is activated but WPBakery Page Builder is not
 */
function wvc_show_wrong_theme_notice() {
	$plugin_data = get_plugin_data( __FILE__ );
	echo '<div class="notice notice-warning">
		<p>' . sprintf(
			wp_kses_post( __( 'Sorry, but <strong>%s</strong> only works with compatible <a target="_blank" href="%s">%s themes</a>.<br><strong>Be sure that you didn\'t change the theme\'s name in the %s file or the theme\'s folder name</strong>.<br>If you want to customize the theme\'s name, you can use a <a target="_blank" href="%s">child theme</a>.', 'wolf-visual-composer' ) ),
				$plugin_data['Name'],
				'https://wlfthm.es/tf',
				'WolfThemes',
				'style.css',
				'https://wolfthemes.ticksy.com/article/11659/'
			) . '</p>
	</div>';
}

/**
 * Is the plugin activated? 
 *
 * @return bool
 */
function wvc_is_activated() {
	if ( ! get_transient( 'wvc_activation_notice' ) && ! get_option( 'wvc_activation_notice_set' ) ) {
		set_transient( 'wvc_activation_notice', true, 31 * DAY_IN_SECONDS );
		update_option( 'wvc_activation_notice_set', true );
	}
	if ( ( get_option( 'wvc_activated' ) || get_transient( 'wvc_activated' ) ) && get_option( 'wvc_key' ) && get_option( 'wvc_code' ) ) {
		return get_option( 'wvc_key' );
	}
	if ( ( ! get_option( 'wvc_activated' ) || ! get_transient( 'wvc_activated' ) ) && ! get_option( 'wvc_key' ) && ! get_option( 'wvc_code' ) && ! get_transient( 'wvc_activation_notice' ) && get_option( 'wvc_activation_notice_set' ) ) {
		return false;
	}
	if ( get_transient( 'wvc_activation_notice' ) && get_option( 'wvc_activation_notice_set' ) ) {
		return true;
	}
	if ( ! get_option( 'wvc_activated' ) && ! get_transient( 'wvc_activation_notice' ) && get_option( 'wvc_code' ) && get_option( 'wvc_key' ) ) {
		
		$remote_url = 'https://api.wolfthemes.com/envato/';
		$response = wp_remote_post( $remote_url, array(
			'method' => 'POST',
			'body' => array(
				'action' => 'verification',
				'code' => get_option( 'wvc_code' ),
				'key' => get_option( 'wvc_key' ),
			),
		) );

		if ( ! is_wp_error( $response ) && is_array( $response ) ) {

			$body = wp_remote_retrieve_body( $response );

			if ( '' === $body ) {
				delete_option( 'wvc_code' );
				delete_option( 'wvc_key' );
				update_option( 'wvc_activation_notice_set', true );
				return false;
			} else {
				update_option( 'wvc_activated', true );
				return true;
			}

		} else {
			delete_option( 'wvc_code' );
			delete_option( 'wvc_key' );
			update_option( 'wvc_activation_notice_set', true );
			return false;
		}
	}
}

/**
 * Not OK bro
 * @return bool
 */
function wvc_wrong_theme() {
	$ok = array( 'wolf-2018', 'protheme', 'iyo', 'loud', 'tune', 'retine', 'racks', 'andre', 'hares', 'glytch', 'superflick', 'phase', 'zample', 'prequelle', 'slikk', 'vonzot', 'deadlift', 'hyperbent', 'kayo', 'reinar', 'snakepit', 'alceste', 'fradence', 'firemaster', 'decibel', 'tattoopress', 'tattoopro', 'milu', 'beatit', 'daeron', 'herion', 'oglin' );

	return ( ! in_array( esc_attr( sanitize_title_with_dashes( get_template() ) ), $ok ) );
}