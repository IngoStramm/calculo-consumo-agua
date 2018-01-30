<?php

add_action( 'cmb2_admin_init', 'calculo_register_metaboxes' );

function calculo_register_metaboxes() {
	$prefix = 'calculo_cmb_';
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Dados de cálculo de consumo de água', 'calculo-consumo-agua' ),
		'object_types'  => array( 'product' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'    => 'side',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );

	$cmb->add_field( array(
		'name' => __( 'Quantidade de água em ml', 'calculo-consumo-agua' ),
		'desc' => __( 'Apenas números', 'calculo-consumo-agua' ),
		'id'   => $prefix . 'number',
		'type' => 'text',
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
		'sanitization_cb' => 'absint',
        'escape_cb'       => 'absint',		
	) );

}
