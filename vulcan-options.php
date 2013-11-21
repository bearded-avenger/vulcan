<?php

class vulcanCustomizer {

	const version = '1.0';

	// leave as soren_options so options are serailzed into one array in db
	private function opt_name() {

		$sorenopts = get_option('soren_options');
		$sorenopts['id'] = 'soren_options';
		update_option('soren_options', $sorenopts);
	}

	// set defaults
	public static function default_opts() {

		$options = array();

		$options['vulcan_accent'] = array(
			'name' 	=> __('Background Color', 'soren'),
			'id' 	=> 'vulcan_accent',
			'default' 	=> '#FFFFFF',
			'type' 	=> 'color'
		);

		return $options;
	}

	// add new options to new section
	public static function register($wp_customize){

		$options = self::default_opts();

		// APPEARENCE
		$wp_customize->add_section( 'vulcan_appearence', array(
			'title' => __( 'Vulcan Appearence', 'soren' ),
			'priority' => 100
		) );

		// BG Color
		$wp_customize->add_setting( 'soren_options[vulcan_accent]', array(
			'type' => 'option',
			'default'	=> $options['vulcan_accent']['default']
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vulcan_accent', array(
			'label' => $options['vulcan_accent']['name'],
			'section' => 'vulcan_appearence',
			'settings' => 'soren_options[vulcan_accent]'
		) ) );

	}

}
// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'vulcanCustomizer' , 'register' ) );