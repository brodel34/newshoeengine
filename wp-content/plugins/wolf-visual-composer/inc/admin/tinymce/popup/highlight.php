<?php
/**
 * Highlight dialog box
 *
 * @class WVC_Admin
 * @author WolfThemes
 * @category Admin
 * @package wpbPageBuilder/Admin
 * @version 3.1.1
 */
?>
<script type="text/javascript">
jQuery( function( $ ) {

	$( '#wpb-insert' ).click( function() {

		var html = tinyMCE.activeEditor.selection.getContent(),
			color = $( '#highlight' ).val();

		output = '[wvc_highlight';
		output += ' color="' +color + '"';
		output += ']'+ html + '[/wvc_highlight]';

		if ( window.tinyMCE  ) {

			window.parent.send_to_editor( output );
			tb_remove();
			return false;
		}
	} );
} );
</script>
<div id="wpb-popup-head"><strong><?php esc_html_e( 'Highlight Text', 'wolf-visual-composer' ); ?></strong></div>
<div id="wpb-popup">
	<form action="#" method="get">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="highlight"><?php esc_html_e( 'Color', 'wolf-visual-composer' ); ?></label></th>
					<td>
						<select name="highlight" id="highlight">
							<option value="yellow"  selected="selected"><?php esc_html_e( 'yellow', 'wolf-visual-composer' ); ?></option>
							<option value="green"><?php esc_html_e( 'green', 'wolf-visual-composer' ); ?></option>
							<option value="red"><?php esc_html_e( 'red', 'wolf-visual-composer' ); ?></option>
							<option value="black"><?php esc_html_e( 'black', 'wolf-visual-composer' ); ?></option>
							<option value="white"><?php esc_html_e( 'white', 'wolf-visual-composer' ); ?></option>
							<option value="accent"><?php esc_html_e( 'accent', 'wolf-visual-composer' ); ?></option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" id="wpb-insert" class="button-primary" value="<?php esc_html_e( 'Wrap selected words', 'wolf-visual-composer' ); ?>"></p>
	</form>
</div>