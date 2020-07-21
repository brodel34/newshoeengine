<?php
	$item_name 	= $this->item_name;
	$item_slug 	= $this->item_slug;
	$license 	= get_option( 'tunsplugins_'.$item_slug.'_license_key' );
	$status 	= get_option( 'tunsplugins_'.$item_slug.'_license_status' );
?>

<h3><?php echo $item_name; ?></h3>

<form method="post" action="">
	<table class="widefat">

		<tbody>
			<tr valign="top">
				<th scope="row" valign="top">
					<strong>License Key</strong>
				</th>
				<td>
					<input id="tunsplugins_<?php echo $item_slug; ?>_license_key" name="tunsplugins_<?php echo $item_slug; ?>_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
					<label class="description" for="tunsplugins_<?php echo $item_slug; ?>_license_key">Enter your license key</label>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" valign="top">
					<?php if ( ! empty( $status ) ): ?>
						<strong>Key Status</strong>
					<?php endif; ?>
				</th>
				<td>
					<?php if( $status !== false && $status == 'valid' ): ?>
						<p style="color:green;"><?php echo $this->key_statuses[ $status ]; ?></p>
						<?php wp_nonce_field( 'tunsplugins_license_nonce', 'tunsplugins_license_nonce' ); ?>
						<input type="hidden" name="tunsplugins_action" value="deactivate_license"/>
						<input type="submit" class="button-secondary" name="tunsplugins_license_deactivate" value="Deactivate License"/>
					<?php else: ?>
						<?php if ( ! empty( $status ) ): ?>
							<p style="color:red;"><?php echo $this->key_statuses[ $status ]; ?></p>
						<?php endif; ?>
						<?php wp_nonce_field( 'tunsplugins_license_nonce', 'tunsplugins_license_nonce' ); ?>
						<input type="hidden" name="tunsplugins_action" value="activate_license"/>
						<input type="submit" class="button-secondary" name="tunsplugins_license_activate" value="Activate License"/>
					<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
</form>