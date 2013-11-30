<?php

class vulcanTheme {

	public function __construct(){

		require_once('vulcan-options.php');

		// Load Updater
		if( !class_exists( 'EDD_SL_Theme_Updater' ) ) {
			// load our custom updater
			include( 'EDD_SL_Theme_Updater.php' );
		}
		require_once('updater.php');

		add_action('wp_enqueue_scripts',array($this,'styles'));

		// core soren less var filter
		add_filter( 'soren_less_vars', array($this,'less_filter'));

		//default options filter
		add_filter('soren_default_options', array($this,'filter_defaults'));

				// translation
		add_action('after_setup_theme', array($this,'textdomain'));
	}

	public function styles(){

		wp_enqueue_style('vulcan-style', SOREN_CHILD_URL.'/style.less', '1.0', true);
		wp_enqueue_script('vulcan-script', SOREN_CHILD_URL.'/vulcan.min.js', array('jquery'), 1.0, true);
	}

	// filtering the main options with new defaults!
	public function filter_defaults(){

		$options = array();

		$options['bg_color'] = array(
			'name' 	=> __('Background Color', 'vulcan'),
			'id' 	=> 'bg_color',
			'default' 	=> '#FFFFFF',
			'type' 	=> 'color'
		);

		$options['link_color'] = array(
			'name' 	=> __('Link Color', 'vulcan'),
			'id' 	=> 'link_color',
			'default' 	=> '#07a1cd',
			'type' 	=> 'color'
		);

		$options['text_color'] = array(
			'name' 	=> __('Text Color', 'vulcan'),
			'id' 	=> 'soren_text_text',
			'default' 	=> '#444444',
			'type' 	=> 'color'
		);

		$options['header_color'] = array(
			'name' 	=> __('Headings Color', 'vulcan'),
			'id' 	=> 'soren_header_text',
			'default' 	=> '#282828',
			'type' 	=> 'color'
		);
		$options['font_size'] = array(
			'name' 	=> __('Font Size', 'vulcan'),
			'id' 	=> 'font_size',
			'default' 	=> '22px',
			'type' 	=> 'select'
		);
		$options['soren_width'] = array(
			'name' 	=> __('Content Width', 'vulcan'),
			'id' 	=> 'soren_width',
			'default' 	=> 800,
			'type' 	=> 'text'
		);

		return $options;

	}

	// example showing how to filter soren core less vars
	public function less_filter($vars){

		$opts 		 = get_option('soren_options') ? get_option('soren_options') : false;
		$headercolor = isset($opts['header_color']) ? $opts['header_color'] : false;

		$vars[ 'soren-headings-color' ]   = $headercolor ? $headercolor : '#282828';

    	return $vars;
	}

	function textdomain() {
		load_theme_textdomain( 'vulcan_translation', SOREN_CHILD_DIR. '/lang' );
	}
}
new vulcanTheme;
