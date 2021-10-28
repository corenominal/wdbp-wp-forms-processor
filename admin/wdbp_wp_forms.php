<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function wdbp_wp_forms_scripts( $hook )
{

	if( 'toplevel_page_wdbp_wp_forms' != $hook )
	{
		return;
	}

	wp_register_style( 'wdbp_wp_forms_css', plugin_dir_url( __FILE__ ) . 'css/wdbp_wp_forms.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'wdbp_wp_forms_css' );

	wp_register_script( 'wdbp_wp_forms_js', plugin_dir_url( __FILE__ ) . 'js/wdbp_wp_forms.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'wdbp_wp_forms_js' );

}
add_action( 'admin_enqueue_scripts', 'wdbp_wp_forms_scripts' );

/**
 * Output HTML
 */
function wdbp_wp_forms_callback()
{
	?>
	<div class="wrap">

		<input type="hidden" id="wdbp-wp-nonce" value="<?php echo wp_create_nonce( "wp_rest" ) ?>">
		
		<div id="wdbp-wp-notify"></div>

		<h1>WDBP WP Forms <a href="admin.php?page=wdbp_wp_forms_create" id="add-new-form" class="page-title-action">Add New</a></h1>

		<p>The following forms are set-up and can be processed.</p>

		<div class="tablenav top">
			<div class="alignleft actions"></div>
			<div class="tablenav-pages">
				<span class="displaying-num"></span>
				<span class="pagination-links">
					<button class="tablenav-pages-navspan button page-first" aria-hidden="true">&laquo;</button>
					<button class="tablenav-pages-navspan button page-prev" aria-hidden="true">&lsaquo;</button>
					<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Current Page</label><span class="current-page">0</span><span class="tablenav-paging-text"> of <span class="total-pages">0</span></span></span>
					<button class="tablenav-pages-navspan button page-next" aria-hidden="true">&rsaquo;</button>
					<button class="tablenav-pages-navspan button page-last" aria-hidden="true">&raquo;</button>
				</span>
			</div>
		</div>

		<table id="wdbp-wp-forms"
			class="forms-list wp-list-table widefat fixed striped"
			data-endpoint="<?php echo site_url('wp-json/wdbp_wp_forms/forms_admin') ?>"
			data-apikey="<?php echo get_option( 'wdbp_wp_forms_apikey', '' ); ?>"
			data-offset="0"
			data-limit="20"
			data-pages="0"
			data-total="0"
		>
        	<thead>
        		<tr>
        			<th class="manage-column column-main column-name" scope="col">Form</th>
        			<th class="manage-column column-submissions" scope="col">Submissions</th>
					<th class="manage-column column-created" scope="col">Created</th>
        			<th class="manage-column column-options" scope="col">Options</th>
        		</tr>
        	</thead>

        	<tbody id="the-list">
        		<tr><td colspan="4">Loading forms ...</td></tr>
        	</tbody>
        </table>

		<div class="tablenav bottom">
			<div class="alignleft actions"></div>
			<div class="tablenav-pages">
				<span class="displaying-num"></span>
				<span class="pagination-links">
					<button class="tablenav-pages-navspan button page-first" aria-hidden="true">&laquo;</button>
					<button class="tablenav-pages-navspan button page-prev" aria-hidden="true">&lsaquo;</button>
					<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Current Page</label><span class="current-page">0</span><span class="tablenav-paging-text"> of <span class="total-pages">0</span></span></span>
					<button class="tablenav-pages-navspan button page-next" aria-hidden="true">&rsaquo;</button>
					<button class="tablenav-pages-navspan button page-last" aria-hidden="true">&raquo;</button>
				</span>
			</div>
		</div>

	</div>
	<?php
}
