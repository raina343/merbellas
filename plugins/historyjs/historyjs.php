<?
/*
Plugin Name: History.js for WordPress
Plugin URI: http://www.ramoonus.nl/wordpress/historyjs/
Description: History.js gracefully supports the HTML5 History/State APIs (pushState, replaceState, onPopState) in all browsers.
Version: 1.7.1.1
Author: Ramoonus
Author URI: http://www.ramoonus.nl/
License: GPL2
*/

/* Javascript declarations for init */
function rw_historyjs_init() {
		wp_deregister_script('historyjs');
		wp_register_script('historyjs', plugins_url('/js/history.adapter.native.js',__FILE__), false, '1.7.1'); 
		wp_enqueue_script('historyjs');

		// history.js for html4
		wp_deregister_script('historyjs4');
		wp_register_script('historyjs4', plugins_url('/js/history.html4.js',__FILE__), false, '1.7.1'); 
		wp_enqueue_script('historyjs4');
}    
add_action('init', 'rw_historyjs_init');
?>