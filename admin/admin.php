<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * WP admin pages for creating creating and managing forms.
 */
function wdbp_wp_forms_admin_options()
{
	// Add top level page
	add_menu_page(
		'WDBP WP Forms', // page title
		'Forms', // menu title
		'edit_plugins', // capability
		'wdbp_wp_forms', // slug
		'wdbp_wp_forms_callback', // callback
		'dashicons-forms', // icon - 20x20 png or SVG - for dashicon just ref the icon 'dashicons-sos'
		22 //position
	);

	add_submenu_page(
		'wdbp_wp_forms', // parent slug
		'All Form', // page title
		'All Forms', // menu title
		'edit_plugins', // capability
		'wdbp_wp_forms', // slug
		'wdbp_wp_forms_callback' // callback function
	);

	add_submenu_page(
		'wdbp_wp_forms', // no parent slug (removes from menu) admin.php?page=wdbp_wp_forms_edit
		'Forms - Edit', // page title
		'Edit', // menu title
		'edit_plugins', // capability
		'wdbp_wp_forms_edit', // slug
		'wdbp_wp_forms_edit_callback' // callback function
	);

	add_submenu_page(
		'wdbp_wp_forms', // no parent slug (removes from menu) admin.php?page=wdbp_wp_forms_edit
		'Forms - Info', // page title
		'Info', // menu title
		'edit_plugins', // capability
		'wdbp_wp_forms_info', // slug
		'wdbp_wp_forms_info_callback' // callback function
	);

	add_submenu_page(
		'wdbp_wp_forms', // parent slug
		'Forms - Add New', // page title
		'Add New', // menu title
		'edit_plugins', // capability
		'wdbp_wp_forms_create', // slug
		'wdbp_wp_forms_create_callback' // callback function
	);

	add_submenu_page(
		'wdbp_wp_forms', // parent slug
		'Forms - Submissions', // page title
		'Submissions', // menu title
		'edit_plugins', // capability
		'wdbp_wp_forms_submissions', // slug
		'wdbp_wp_forms_submissions_callback' // callback function
	);

}
add_action( 'admin_menu', 'wdbp_wp_forms_admin_options' );

/**
 * Include admin views
 */
require_once( plugin_dir_path( __FILE__ ) . 'wdbp_wp_forms.php' );
require_once( plugin_dir_path( __FILE__ ) . 'wdbp_wp_forms_create.php' );
require_once( plugin_dir_path( __FILE__ ) . 'wdbp_wp_forms_edit.php' );
require_once( plugin_dir_path( __FILE__ ) . 'wdbp_wp_forms_info.php' );
require_once( plugin_dir_path( __FILE__ ) . 'wdbp_wp_forms_submissions.php' );

/**
 * Enqueue additional JavaScript and CSS
 */
function wdbp_wp_forms_enqueue_css( )
{
	wp_register_style( 'wdbp_wp_forms_all_css', plugin_dir_url( __FILE__ ) . 'css/wdbp_wp_forms_all.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'wdbp_wp_forms_all_css' );
}
add_action( 'admin_enqueue_scripts', 'wdbp_wp_forms_enqueue_css' );
