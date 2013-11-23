<?php

class vulcanTheme {

	public function __construct(){

		require_once('vulcan-options.php');
		add_action('wp_enqueue_scripts',array($this,'styles'));

		// core soren less var filter
		add_filter( 'soren_less_vars', array($this,'less_filter'));

		//default options filter
		add_filter('soren_default_options', array($this,'filter_defaults'));
	}

	public function styles(){

		wp_enqueue_style('vulcan-style', SOREN_CHILD_URL.'/style.less', '1.0', true);
		wp_enqueue_script('vulcan-script', SOREN_CHILD_URL.'/vulcan.js', array('jquery'), 1.0, true);
	}

	// filtering the main options with new defaults!
	public function filter_defaults(){

		$options = array();

		$options['bg_color'] = array(
			'name' 	=> __('Background Color', 'soren'),
			'id' 	=> 'bg_color',
			'default' 	=> '#FFFFFF',
			'type' 	=> 'color'
		);

		$options['link_color'] = array(
			'name' 	=> __('Link Color', 'soren'),
			'id' 	=> 'link_color',
			'default' 	=> '#07a1cd',
			'type' 	=> 'color'
		);

		$options['text_color'] = array(
			'name' 	=> __('Text Color', 'soren'),
			'id' 	=> 'soren_text_text',
			'default' 	=> '#444444',
			'type' 	=> 'color'
		);

		$options['header_color'] = array(
			'name' 	=> __('Headings Color', 'soren'),
			'id' 	=> 'soren_header_text',
			'default' 	=> '#282828',
			'type' 	=> 'color'
		);

		$options['font_size'] = array(
			'name' 	=> __('Font Size', 'soren'),
			'id' 	=> 'font_size',
			'default' 	=> '22px',
			'type' 	=> 'select'
		);
		$options['soren_width'] = array(
			'name' 	=> __('Content Width', 'soren'),
			'id' 	=> 'soren_width',
			'default' 	=> 800,
			'type' 	=> 'text'
		);
		$options['soren_ga'] = array(
			'name' 	=> __('Google Analytics Tracking ID', 'soren'),
			'id' 	=> 'soren_ga',
			'default' 	=> ' ',
			'type' 	=> 'text'
		);

		$options['soren_fb_app_id'] = array(
			'name' 	=> __('Facebook APP ID', 'soren'),
			'id' 	=> 'soren_fb_app_id',
			'default' 	=> ' ',
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
}
new vulcanTheme;
