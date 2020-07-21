<?php
/**
 * Accordion
 *
 * @author WolfThemes
 * @category Core
 * @package WolfVisualComposer/Elements
 * @version 3.1.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Mp_Time_Table' ) ) {
	return;
}

if ( 'mp-column' === wvc_get_current_post_type() ) {
	return;
}
$column_posts = get_posts( 'post_type="mp-column"&numberposts=-1' );
$columns_array = array();
if ( $column_posts ) {
	foreach ( $column_posts as $column_options ) {
		$columns_array[ $column_options->post_title ] = $column_options->ID;
	}
} else {
	$columns_array[ esc_html__( 'No Columns Yet', 'wolf-visual-composer' ) ] = 0;
}
$event_posts = get_posts( 'post_type="mp-event"&numberposts=-1' );
$events_array = array();
if ( $event_posts ) {
	foreach ( $event_posts as $event_options ) {
		$events_array[ $event_options->post_title ] = $event_options->ID;
	}
} else {
	$events_array[ esc_html__( 'No Columns Yet', 'wolf-visual-composer' ) ] = 0;
}
$event_categories = get_terms( 'mp-event_category', 'orderby=count&hide_empty=0' );
$event_categories_array = array();
if ( $event_categories ) {
	foreach ( $event_categories as $event_categories_options ) {
		$event_categories_array[ $event_categories_options->name ] = $event_categories_options->term_id;
	}
} else {
	$event_categories_array[ esc_html__( 'No Category Yet', 'wolf-visual-composer' ) ] = 0;
}

vc_map(
	array(
		'name' => esc_html__( 'Timetable', 'wolf-visual-composer' ),
		'base' => 'mp-timetable',
		'icon' => 'fa fa-calendar',
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'description' => sprintf( wvc_kses( __( 'Timetable from %s plugins', 'wolf-visual-composer' ) ), 'MotoPress TimeTable Plugin' ),
		'params' => array(
			array(
				'type' => 'wvc_dropdown_multi',
				'heading' => esc_html__( 'Columns (required)', 'wolf-visual-composer' ),
				'param_name' => 'col',
				'value' => $columns_array,
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_dropdown_multi',
				'heading' => esc_html__( 'Specific events', 'wolf-visual-composer' ),
				'param_name' => 'events',
				'value' => $events_array,
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_dropdown_multi',
				'heading' => esc_html__( 'Events Categories', 'wolf-visual-composer' ),
				'param_name' => 'event_categ',
				'value' => $event_categories_array,
				'admin_label' => true,
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => true ),
				'std' => true,
				'admin_label' => true,
				'edit_field_class' => 'vc_col-xs-3',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show Time', 'wolf-visual-composer' ),
				'param_name' => 'time',
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => true ),
				'std' => true,
				'admin_label' => true,
				'edit_field_class' => 'vc_col-xs-3',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show Subtitle', 'wolf-visual-composer' ),
				'param_name' => 'sub-title',
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => true ),
				'std' => true,
				'admin_label' => true,
				'edit_field_class' => 'vc_col-xs-3',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show Description', 'wolf-visual-composer' ),
				'param_name' => 'description',
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => true ),
				'admin_label' => true,
				'edit_field_class' => 'vc_col-xs-3',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Event Head', 'wolf-visual-composer' ),
				'param_name' => 'user',
				'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => true ),
				'admin_label' => true,
				'edit_field_class' => 'vc_col-xs-3',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Block height in pixels', 'wolf-visual-composer' ),
				'param_name' => 'row_height',
				'value' => 90,
				'description' => esc_html__( 'Set height of the block.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Base font size', 'wolf-visual-composer' ),
				'param_name' => 'font_size',
				'value' => '13px',
				'description' => esc_html__( 'Base font size for the table. Example 12px, 2em, 80%.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Time frame for event', 'wolf-visual-composer' ),
				'param_name' => 'increment',
				'value' => array(
					esc_html__( 'Hour (1h)', 'wolf-visual-composer' ) => '1',
					esc_html__( 'Half hour (30min)', 'wolf-visual-composer' ) => '0.5',
					esc_html__( 'Quarter hour (15min)', 'wolf-visual-composer' ) => '0.25',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Filter events style', 'wolf-visual-composer' ),
				'param_name' => 'view',
				'value' => array(
					esc_html__( 'Tabs', 'wolf-visual-composer' ) => 'tabs',
					esc_html__( 'Dropdown', 'wolf-visual-composer' ) => 'dropdown_list',
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
				),
				'std' => 'tabs',
				'save_always' => true,
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Filter title to display all events', 'wolf-visual-composer' ),
				'param_name' => 'label',
				'value' => esc_html__( 'All Events', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hide "All Events" option', 'wolf-visual-composer' ),
				'param_name' => 'hide_label',
				'value' => array(
					esc_html__( 'No', 'wolf-visual-composer' ) => '0',
					esc_html__( 'Yes', 'wolf-visual-composer' ) => '1',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hide column with hours', 'wolf-visual-composer' ),
				'param_name' => 'hide_hrs',
				'value' => array(
					esc_html__( 'No', 'wolf-visual-composer' ) => '0',
					esc_html__( 'Yes', 'wolf-visual-composer' ) => '1',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Do not display empty rows', 'wolf-visual-composer' ),
				'param_name' => 'hide_empty_rows',
				'value' => array(
					esc_html__( 'Yes', 'wolf-visual-composer' ) => '1',
					esc_html__( 'No', 'wolf-visual-composer' ) => '0',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Merge cells with common events', 'wolf-visual-composer' ),
				'param_name' => 'group',
				'value' => array(
					esc_html__( 'No', 'wolf-visual-composer' ) => '0',
					esc_html__( 'Yes', 'wolf-visual-composer' ) => '1',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Disable event link', 'wolf-visual-composer' ),
				'param_name' => 'disable_event_url',
				'value' => array(
					esc_html__( 'No', 'wolf-visual-composer' ) => '0',
					esc_html__( 'Yes', 'wolf-visual-composer' ) => '1',
				),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Horizontal align', 'wolf-visual-composer' ),
				'param_name' => 'text_align',
				'value' => array(
					esc_html__( 'center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'right', 'wolf-visual-composer' ) => 'right',
				),
				'edit_field_class' => 'vc_col-xs-6',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Vertical align', 'wolf-visual-composer' ),
				'param_name' => 'text_align_vertical',
				'value' => array(
					esc_html__( 'middle', 'wolf-visual-composer' ) => 'middle',
					esc_html__( 'top', 'wolf-visual-composer' ) => 'top',
					esc_html__( 'bottom', 'wolf-visual-composer' ) => 'bottom',
				),
				'edit_field_class' => 'vc_col-xs-6',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Unique ID', 'wolf-visual-composer' ),
				'param_name' => 'id',
				'description' => esc_html__( 'If you use more than one table on a page specify the unique ID for a timetable. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'CSS class', 'wolf-visual-composer' ),
				'param_name' => 'custom_class',
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Mobile behavior', 'wolf-visual-composer' ),
				'param_name' => 'responsive',
				'description' => esc_html__( 'Choose "List" to display events in a list view on mobile devices. Choose "Table" to display events in a table.', 'wolf-visual-composer' ),
				'value' => array(
					esc_html__( 'List', 'wolf-visual-composer' ) => '1',
					esc_html__( 'Table', 'wolf-visual-composer' ) => '0',
				),
				'admin_label' => true,
			),
		),
	)
);