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

vc_map(
	array(
		'name' => esc_html__( 'Accordion', 'wolf-visual-composer' ),
		'base' => 'vc_accordion',
		'show_settings_on_create' => false,
		'is_container' => true,
		'icon' => 'fa fa-indent',
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Collapsible panels', 'wolf-visual-composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Active section', 'wolf-visual-composer' ),
				'param_name' => 'active_tab',
				'description' => esc_html__( 'Enter section number to be active on load. Leave empty to open the first panel by default and enter "0" to collapse all panels on load.', 'wolf-visual-composer' ),
			),
		),
		'custom_markup' => '
	<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
	%content%
	</div>
	<div class="tab_controls">
	    <a class="add_tab" title="' . esc_html__( 'Add section', 'wolf-visual-composer' ) . '"><span class="vc_icon"></span> <span class="tab-label">' . esc_html__( 'Add section', 'wolf-visual-composer' ) . '</span></a>
	</div>
	',
		'default_content' => '
	    [vc_accordion_tab title="' . esc_html__( 'Section 1', 'wolf-visual-composer' ) . '"][/vc_accordion_tab]
	    [vc_accordion_tab title="' . esc_html__( 'Section 2', 'wolf-visual-composer' ) . '"][/vc_accordion_tab]
	',
		'js_view' => 'VcAccordionView',
	)
);

vc_map(
	array(
		'name' => esc_html__( 'Section', 'wolf-visual-composer' ),
		'base' => 'vc_accordion_tab',
		'allowed_container_element' => 'vc_row',
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Accordion section title.', 'wolf-visual-composer' ),
			),
		),
		'js_view' => 'VcAccordionTabView',
	)
);