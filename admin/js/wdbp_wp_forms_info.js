jQuery(document).ready(function($){

    // Get wp nonce for authentication and set-up ajax
    $.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader( 'X-WP-Nonce', $( '#wdbp-wp-nonce' ).val() );
        }
    });

    /**
     * Test for form
     */
    var endpoint = $( '#wdbp-wp-forms-name' ).data( 'endpoint' );
    var data = {
        action: 'get_form',
        form: $( '#wdbp-wp-forms-name' ).data( 'form' )
    };

    $.ajax({
        url: endpoint,
        type: 'GET',
        dataType: 'json',
        data: data
    })
    .done(function( data ) {
        if( data.error )
        {
            window.location.href = "admin.php?page=wdbp_wp_forms";
        }
        else
        {
            $( '.wdbp-wp-forms-field-form' ).html( data.form.form );
            $( '#wdbp-wp-forms-field-required' ).html( 'none' );
            if( data.form.required_fields != '[]' )
            {
                var li = '<ul class="wdbp-wp-forms-required-fields-list">';
                var desc = '<p class="description">';
                desc += 'Required field(s) within your AJAX payload. E.g.<br>{';
                var required_fields = JSON.parse( data.form.required_fields );
                $.each(required_fields, function( key, val )
                {
                    li += '<li><code>' + val + '</code></li>';
                    desc += val + ": 'value', ";
                });
                li += '</ul>';
                desc += ' ... }</p>';
                $( '#wdbp-wp-forms-field-required' ).html( li + desc )
            }
        }
    })
    .fail(function( data ) {
        console.log( "error" );
    });

});
