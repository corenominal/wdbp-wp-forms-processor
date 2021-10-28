<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Plugin Name: WDBP WP Forms Processor
 * Plugin URI: https://github.com/corenominal/wdbp-wp-forms-processor
 * Description: A form processor plugin for WordPress.
 * Author: Philip Newborough
 * Version: 0.0.1
 * Author URI: https://corenominal.com
 */

/**
 * Plugin activation functions
 */
function wdbp_wp_form_processor_activate()
{
   require_once( plugin_dir_path( __FILE__ ) . 'activation/db.php' );
   require_once( plugin_dir_path( __FILE__ ) . 'activation/create-api-key.php' );
}
register_activation_hook( __FILE__, 'wdbp_wp_form_processor_activate' );

/**
 * Admin views
 */
require_once( plugin_dir_path( __FILE__ ) . 'admin/admin.php' );

/**
 * Endpoints
 */
require_once( plugin_dir_path( __FILE__ ) . 'endpoints/endpoints.php' );
