<?php

defined( 'ABSPATH' ) or die(':)');

function intro_popup_video_admin_style(){
	wp_enqueue_style( 'itro-popup-video-admin-style', plugins_url('/css/ipv-admin.css', __FILE__), array(), time(), "all" );
}
add_action('admin_enqueue_scripts', 'intro_popup_video_admin_style');


//function for admin menu
function intro_popup_video_add_menu_page() {
    add_menu_page(
        __('General Settings', 'intro-popup-video'),
        __('Intro Popup Video', 'intro-popup-video'),
        'manage_options',
        'intor-video-option',
        'intro_popup_video_general_settings_page',
        'dashicons-format-video',
        100
    );
}
add_action( 'admin_menu', 'intro_popup_video_add_menu_page');

require_once dirname( __FILE__ ). '/settings.php';