<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function wdbp_wp_forms_info_scripts( $hook )
{

	if( 'forms_page_wdbp_wp_forms_info' != $hook )
	{
		return;
	}

    wp_register_style( 'wdbp_wp_forms_info_css', plugin_dir_url( __FILE__ ) . 'css/wdbp_wp_forms_info.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'wdbp_wp_forms_info_css' );

	wp_register_script( 'wdbp_wp_forms_info_js', plugin_dir_url( __FILE__ ) . 'js/wdbp_wp_forms_info.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'wdbp_wp_forms_info_js' );

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'wdbp_wp_forms_info_scripts' );

/**
 * Output HTML
 */
function wdbp_wp_forms_info_callback()
{
	?>
	<div class="wrap">

		<input type="hidden" id="wdbp-wp-nonce" value="<?php echo wp_create_nonce( "wp_rest" ) ?>">

		<h1>WDBP WP Forms: Info</h1>

		<p>Details for implementing this form from within your theme.</p>

		<div id="wdbp-wp-forms-panel" class="wdbp-wp-forms-panel">

			<table class="form-table" data-form="<?php echo $_GET['form']; ?>" id="wdbp-wp-forms-name" data-endpoint="<?php echo site_url('wp-json/wdbp_wp_forms/forms_admin') ?>" data-apikey="<?php echo get_option( 'wdbp_wp_forms_apikey', '' ); ?>">
				<tbody>

					<tr>
						<th scope="row">Endpoint</th>
						<td>
							<code id="wdbp-wp-forms-endpoint"><?php echo site_url('wp-json/wdbp_wp_forms/processor') ?></code>
							<p class="description">The endpoint for your AJAX calls.</p>
						</td>
					</tr>

					<tr>
						<th scope="row">Form</th>
						<td>
							<code class="wdbp-wp-forms-field-form"></code>
							<p class="description">
								Required key value pair within your AJAX payload. E.g:<br>
								{ form: '<span class="wdbp-wp-forms-field-form">a2c6853c7c3e83cfb9fad7da73c79d695f31c218</span>', key: 'value' ... }
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row">Required fields</th>
						<td>
							<span id="wdbp-wp-forms-field-required"></span>
						</td>
					</tr>

					<tr>
						<th scope="row">Security Nonce</th>
						<td>
							<code>&lt;input type="hidden" id="security" value="&lt;?php echo wp_create_nonce( "wp_rest" ) ?&gt;"&gt;</code>
							<p class="description">Required nonce, set as example above. Then send as custom header with AJAX call, as example below.</p>
							<pre><code>$.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader( 'X-WP-Nonce', $( '#security' ).val() );
    }
});

$.ajax({
	url: endpoint,
	type: 'POST',
	...</code></pre>
						</td>
					</tr>

				</tbody>
			</table>

		</div>

	</div>
	<?php
}
