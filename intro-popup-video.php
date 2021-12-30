<?php
/*
Plugin Name: Intro Popup Video
Plugin URI: 
Description: Display YouTube, Vimeo, and MP4 Video in Popup. Pop-up Video on Page Load, Responsive video Popup, Retina ready, visual editor, unlimited Popup's, and many features! Easy to use.
Version: 0.0.1
Author: Nazmul Hasan
Author URI: 
License: GPLv2 or later
Text Domain: intro-popup-video
*/


defined( 'ABSPATH' ) or die(':)');


function intro_popup_video_load_textdomain() {
    load_plugin_textdomain( 'intro-popup-video', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'intro_popup_video_load_textdomain' );


function intro_popup_video_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'intro-popup-video' ) !== false ) {
		$new_links = array(
						'<a title="'.esc_attr__("Need help? Support? Questions? Read the Explanation of Use.", "intro-popup-video").'" href="IntroPopUpVideo-UsageLink" target="_blank">'.__("Explanation of Use", "intro-popup-video").'</a>',
						'<a href="morePluginLink" target="_blank">'.__("More Plugins", "intro-popup-video").'</a>'
					);
		
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
}
add_filter( 'plugin_row_meta', 'intro_popup_video_plugin_row_meta', 10, 2 );


//enque script
function load_plugin_scripts(){
	wp_enqueue_style( 'plyr-style', plugins_url( 'assets/css/plyr.css', __FILE__ ), [], false, 'all');
	wp_enqueue_style( 'ipv-style', plugins_url( 'assets/css/ipv-style.css', __FILE__ ), [], false, 'all');
	
	wp_enqueue_script( 'script-name-nazmul',  plugins_url( 'assets/js/plyr.polyfilled.js', __FILE__ ), [], false, true );
}
add_action('wp_enqueue_scripts', 'load_plugin_scripts');

//dectivate plugin
function intro_popup_video_deactivate(){
	delete_option( 'ipv-video' ); 
}
register_deactivation_hook( __FILE__, 'intro_popup_video_deactivate' );


//requer file
require_once dirname( __FILE__ ). '/admin/admin.php';