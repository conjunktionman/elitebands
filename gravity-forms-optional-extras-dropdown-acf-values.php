<?php

if ( !is_admin() ) {
	// Booking form + optional extras
	add_filter( 'gform_pre_render_6', 'populate_optional_extras_dropdown' );
	add_filter( 'gform_pre_validation_6', 'populate_optional_extras_dropdown' );
	add_filter( 'gform_admin_pre_render_6', 'populate_optional_extras_dropdown' );
	add_filter( 'gform_pre_submission_filter_6', 'populate_optional_extras_dropdown' );

	function populate_optional_extras_dropdown( $form ) {
		if ( $form['id'] != 6 ) {
			return $form;
		}

		$acf_repeater = get_field( 'optional_extras_repeater' );

		// declare the array
		$dropdownitems = array();

		foreach ($acf_repeater as $acf_repeater_subfield) {
			$dropdownitems[] = array(
				'value' => $acf_repeater_subfield['optional_extra'] . ' £' . $acf_repeater_subfield['price'],
				'price' => $acf_repeater_subfield['fee'],
				'text' => $acf_repeater_subfield['optional_extra'] . ' £' . $acf_repeater_subfield['price']
			);
		}

		//Add repeater values as dropdown options
		foreach ( $form['fields'] as &$field ) {
			if ( $field->id == 49 ) {
				$field->choices = $dropdownitems;
			}
		}

		return $form;
		wp_reset_postdata();
	}
}