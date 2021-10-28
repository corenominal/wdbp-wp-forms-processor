<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function wdbp_wp_forms_submission_scripts( $hook )
{

	if( 'forms_page_wdbp_wp_forms_submissions' != $hook )
	{
		return;
	}

	add_thickbox();

	wp_register_style( 'wdbp_wp_forms_submissions_css', plugin_dir_url( __FILE__ ) . 'css/wdbp_wp_forms_submissions.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'wdbp_wp_forms_submissions_css' );

	wp_register_script( 'wdbp_wp_forms_submissions_js', plugin_dir_url( __FILE__ ) . 'js/wdbp_wp_forms_submissions.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'wdbp_wp_forms_submissions_js' );

}
add_action( 'admin_enqueue_scripts', 'wdbp_wp_forms_submission_scripts' );

/**
 * Output HTML
 */
function wdbp_wp_forms_submissions_callback()
{
	?>
	<div class="wrap">

		<input type="hidden" id="wdbp-wp-nonce" value="<?php echo wp_create_nonce( "wp_rest" ) ?>">

		<h1>WDBP WP Forms: Submissions</h1>

		<?php
		if( isset( $_GET['name'] ) && !empty( $_GET['name'] )  )
		{
			echo '<p>Data captured from your form: <strong>' . $_GET['name'] . '</strong></p>';
		}
		else
		{
			echo '<p>Data captured from your forms.</p>';
		}
		?>

		<p class="search-box">
			<label class="screen-reader-text" for="wdbp-wp-forms-search">Search submission:</label>
			<input type="search" id="wdbp-wp-forms-search" value="" spellcheck="false" data-ms-editor="true" placeholder="Search">
		</p>

		<div class="tablenav top">
			
			<div class="alignleft actions">
				<button class="wdbp-wp-forms-remove-selected-subs button" disabled="disabled">Remove Selected</button>
				<button class="wdbp-wp-forms-remove-all-subs button" disabled="disabled">Remove All</button>
			</div>
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

		<table id="wdbp-wp-forms-submissions" class="submissions-list updates-table wp-list-table widefat fixed striped posts"
		       data-offset="0"
			   <?php
			   $form = 'all';
			   if( isset( $_GET['form'] ) && is_numeric( $_GET['form'] )  )
			   {
				   $form = $_GET['form'];
			   }
			   ?>
			   data-form="<?php echo $form ?>"
			   data-limit="20"
			   data-pages="0"
			   data-total="0"
			   data-endpoint="<?php echo site_url('wp-json/wdbp_wp_forms/forms_admin') ?>"
			   data-apikey="<?php echo get_option( 'wdbp_wp_forms_apikey', '' ); ?>"
		>
        	<thead>
        		<tr>
					<td class="manage-column column-cb check-column" scope="col"><input id="wdbp-wp-forms-checkall-subs" class="wdbp-wp-forms-checkall-subs" type="checkbox" value=""></td>
					<th class="manage-column column-name column-main" scope="col">Form</th>
					<th class="manage-column column-created" scope="col">Date Submitted</th>
        			<th class="manage-column column-options" scope="col">IP Address</th>
        		</tr>
        	</thead>

        	<tbody id="the-list">
        		<tr class="wdbp-wp-forms-no-subs"><th colspan="4">Loading submissions ...</th></tr>
        	</tbody>
        </table>

		<div class="tablenav bottom">
			<div class="alignleft actions">
				<button class="wdbp-wp-forms-remove-selected-subs button" disabled="disabled">Remove Selected</button>
				<button class="wdbp-wp-forms-remove-all-subs button" disabled="disabled">Remove All</button>
			</div>
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

		<div id="wdbp-wp-forms-notify-remove-selected">
			<h3>Remove Selected</h3>
			<p><strong>Are you sure?</strong> This action cannot be undone.</p>
			<p>
				<button id="wdbp-wp-forms-confirm-remove-selected-subs" class="button">Yes</button>
				<button class="button wdbp-thickbox-dismiss-button">No</button>
			</p>
		</div>

		<div id="wdbp-wp-forms-notify-remove-all">
			<h3>Remove All</h3>
			<p><strong>Are you sure?</strong> This action cannot be undone.</p>
			<p>
				<button id="wdbp-wp-forms-confirm-remove-all-subs" class="button">Yes</button>
				<button class="button wdbp-thickbox-dismiss-button">No</button>
			</p>
		</div>

	</div>
	<?php
}
