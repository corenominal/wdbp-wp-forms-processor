<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function wdbp_wp_forms_edit_scripts( $hook )
{

	if( 'forms_page_wdbp_wp_forms_edit' != $hook )
	{
		return;
	}

    wp_register_style( 'wdbp_wp_forms_edit_css', plugin_dir_url( __FILE__ ) . 'css/wdbp_wp_forms_edit.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'wdbp_wp_forms_edit_css' );

	wp_register_script( 'wdbp_wp_forms_edit_js', plugin_dir_url( __FILE__ ) . 'js/wdbp_wp_forms_edit.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'wdbp_wp_forms_edit_js' );

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'wdbp_wp_forms_edit_scripts' );

/**
 * Output HTML
 */
function wdbp_wp_forms_edit_callback()
{
	?>
	<div class="wrap">

		<input type="hidden" id="wdbp-wp-nonce" value="<?php echo wp_create_nonce( "wp_rest" ) ?>">

		<h1>WDBP WP Forms: <span id="action">Edit</span></h1>

		<p>Use the form below to edit this form's attributes.</p>

		<div id="wdbp-wp-forms-save-notify" class="wdbp-wp-forms-save-notify"></div>

		<div id="wdbp-wp-forms-panel" class="wdbp-wp-forms-panel">
			<table class="form-table">
				<tbody>
                    <tr>
						<th scope="row">Form name</th>
						<td>
							<input data-form="<?php echo $_GET['form']; ?>" type="text" class="regular-text wdbp-wp-forms-input wdbp-wp-forms-name" id="wdbp-wp-forms-name" spellcheck="true" autocomplete="off" data-endpoint="<?php echo site_url('wp-json/wdbp_wp_forms/forms_admin') ?>" data-apikey="<?php echo get_option( 'wdbp_wp_forms_apikey', '' ); ?>">
						</td>
					</tr>

                    <tr>
						<th scope="row">Required fields</th>
						<td>
							<input type="text" class="regular-text wdbp-wp-forms-required-field-input" value="" id="wdbp-wp-forms-required-field-input" autocomplete="off">
                            <button id="wdbp-wp-forms-add-required-field-button" class="button wdbp-wp-forms-add-required-field-button">Add</button>
                            <p class="description">Add the names of any required fields.</p>
                            <ul id="required-fields-list" class="required-fields-list wdbp-wp-forms-list"></ul>
						</td>
					</tr>

                    <tr>
						<th scope="row">Recipients (to:)</th>
						<td>
							<input type="text" class="regular-text wdbp-wp-forms-to-recipients-input" value="" id="wdbp-wp-forms-to-recipients-input" autocomplete="off">
                            <button id="wdbp-wp-forms-add-to-recipients-button" class="button wdbp-wp-forms-add-to-recipients-button">Add</button>
                            <p class="description">Email addresses to send results to.</p>
                            <ul id="to-recipients-list" class="to-recipients-list wdbp-wp-forms-list"></ul>
						</td>
					</tr>

                    <tr>
						<th scope="row">Recipients (cc:)</th>
						<td>
							<input type="text" class="regular-text wdbp-wp-forms-cc-recipients-input" value="" id="wdbp-wp-forms-cc-recipients-input" autocomplete="off">
                            <button id="wdbp-wp-forms-add-cc-recipients-button" class="button wdbp-wp-forms-add-cc-recipients-button">Add</button>
                            <p class="description">Email addresses to CC results to.</p>
                            <ul id="cc-recipients-list" class="cc-recipients-list wdbp-wp-forms-list"></ul>
						</td>
					</tr>

                    <tr>
						<th scope="row">Recipients (bcc:)</th>
						<td>
							<input type="text" class="regular-text wdbp-wp-forms-bcc-recipients-input" value="" id="wdbp-wp-forms-bcc-recipients-input" autocomplete="off">
                            <button id="wdbp-wp-forms-add-bcc-recipients-button" class="button wdbp-wp-forms-add-bcc-recipients-button">Add</button>
                            <p class="description">Email addresses to BCC results to.</p>
                            <ul id="bcc-recipients-list" class="bcc-recipients-list wdbp-wp-forms-list"></ul>
						</td>
					</tr>

				</tbody>
			</table>

			<p>
				<button id="wdbp-wp-forms-save-form" class="button button-primary button-large" disabled="disabled">Save Form</button>
			</p>

		</div>

	</div>
	<?php
}
