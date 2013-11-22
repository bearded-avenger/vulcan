<?php

class vulcanCustomizer {

	const version = '1.0';


	public static function custom_colors($vars){

		$opts 		 = get_option('vulcan_options') ? get_option('vulcan_options') : false;
		$accent 	 = isset($opts['vulcan_accent']) ? $opts['vulcan_accent'] : false;

		$vars[ 'vulcan-accent' ] 		= $accent ? $accent : '#282828';

    	return $vars;

	}

	// leave as vulcan_options so options are serailzed into one array in db
	private function opt_name() {

		$sorenopts = get_option('vulcan_options');
		$sorenopts['id'] = 'vulcan_options';
		update_option('vulcan_options', $sorenopts);
	}

	// set defaults
	public static function default_opts() {

		$options = array();

		$options['vulcan_accent'] = array(
			'name' 	=> __('Background Color', 'vulcan'),
			'id' 	=> 'vulcan_accent',
			'default' 	=> '#282828',
			'type' 	=> 'color'
		);

		$options['vulcan_footer_text'] = array(
			'name' 	=> __('Footer Text', 'vulcan'),
			'id' 	=> 'vulcan_footer_text',
			'default' 	=> 'Proudy Powered by Wordpress',
			'type' 	=> 'text'
		);

		return $options;
	}

	// add new options to new section
	public static function register($wp_customize){

		$options = self::default_opts();

		// APPEARENCE
		$wp_customize->add_section( 'vulcan_appearence', array(
			'title' => __( 'Vulcan Options', 'vulcan' ),
			'priority' => 100
		) );

		// BG Color
		$wp_customize->add_setting( 'vulcan_options[vulcan_accent]', array(
			'type' => 'option',
			'default'	=> $options['vulcan_accent']['default']
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vulcan_accent', array(
			'label' => $options['vulcan_accent']['name'],
			'section' => 'vulcan_appearence',
			'settings' => 'vulcan_options[vulcan_accent]'
		) ) );

		// footer text

		// Footer Text
		$wp_customize->add_setting( 'vulcan_options[vulcan_footer_text]', array(
            'default'           =>  $options['vulcan_footer_text']['default'],
            'type'              => 'option',
            'transport'         => 'postMessage',
            'sanitize_callback' => self::sanitize_text_field(),
        ) );
        $wp_customize->add_control( new Soren_WP_Customize_Textarea_Control( $wp_customize, 'vulcan_options[vulcan_footer_text]', array(
            'label'    => __( 'Footer Text', 'vulcan' ),
            'section'  => 'vulcan_appearence',
            'settings' => 'vulcan_options[vulcan_footer_text]',
            'type' => $options['vulcan_footer_text']['type'],
            'transport' => 'postMessage'
        ) ) );

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}

	/*
	* Uncomment this if you are going to use real time updating of text. you'll need to of course put a js file in your child theme with the right js calls
	*/
	public static function live_preview() {
      	wp_enqueue_script('soren-themecustomizer',SOREN_CHILD_URL.'/theme-customizer.js', array( 'jquery','customize-preview' ), true);
    }

    // Sanitize Footer Text
	private static function sanitize_footer_text( $input = '' ) {
	    return stripslashes_deep( $input );
	}

	private static function sanitize_text_field( $input = ''  ) {
		return sanitize_text_field( $input );
	}

	private static function sanitize_int( $input = ''  ) {
		return wp_filter_nohtml_kses( round( $input ) );

	}

}
// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'vulcanCustomizer' , 'register' ) );
add_filter( 'less_vars', array( 'vulcanCustomizer' , 'custom_colors'));


// Enqueue live preview javascript in Theme Customizer admin screen
// Uncomment this if you are using the real time updating as set in teh class above
add_action( 'customize_preview_init' , array( 'vulcanCustomizer' , 'live_preview' ) );




