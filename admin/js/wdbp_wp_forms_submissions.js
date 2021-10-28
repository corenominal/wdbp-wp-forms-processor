jQuery(document).ready(function($)
{
    // Get wp nonce for authentication and set-up ajax
    $.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader( 'X-WP-Nonce', $( '#wdbp-wp-nonce' ).val() );
        }
    });

    /**
	 * List submissions
	 */
    function get_subs()
    {
        $( '.tablenav-pages-navspan' ).attr('disabled', 'disabled');
        var endpoint = $( '#wdbp-wp-forms-submissions' ).data( 'endpoint' );
        var data = {
            action: 'list_subs',
            offset: $( '#wdbp-wp-forms-submissions' ).data( 'offset' ),
            limit: $( '#wdbp-wp-forms-submissions' ).data( 'limit' ),
            form: $( '#wdbp-wp-forms-submissions' ).data( 'form' ),
            search: $( '#wdbp-wp-forms-search' ).val(),
        };
        
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            data: data
        })
        .done(function( data ) {
            var items = data.total.submissions;
            $( '.displaying-num' ).html( items + ' items' );

            // Paging
            if( items > 0 )
            {
                $( '.wdbp-wp-forms-remove-all-subs' ).removeAttr( 'disabled' );
                var limit = $( '#wdbp-wp-forms-submissions' ).data( 'limit' );
                var pages = Math.ceil( items / limit );
                $( '#wdbp-wp-forms-submissions' ).data( 'pages', pages );
                $( '#wdbp-wp-forms-submissions' ).data( 'total', items );
                var offset = $( '#wdbp-wp-forms-submissions' ).data( 'offset' );
                var page = (offset + limit) / limit;
                $( '.current-page' ).html( page );
                $( '.total-pages' ).html( pages );

                if( page < pages )
                {
                    $( '.page-next' ).removeAttr('disabled');
                    $( '.page-last' ).removeAttr('disabled');
                }

                if( page > 1 )
                {
                    $( '.page-prev' ).removeAttr('disabled');
                    $( '.page-first' ).removeAttr('disabled');
                }

            }
            else
            {
                $( '.tablenav-pages-navspan' ).attr('disabled', 'disabled');
            }

            var subs = '';
			if( data.num_rows == 0 )
			{
				subs = '<tr><th colspan="4">No data found!</th></tr>';
			}
			else
			{
				$.each(data.subs, function(i, sub)
				{
                    subs += '<tr class="sub" data-id="' + sub.id + '">';
                    subs += '<th class="check-column"><input class="wdbp-wp-forms-remove-sub" type="checkbox" value="' + sub.id + '"></th>';
                    subs += '<td class="column-main wdbp-wp-forms-sub">' + sub.name + '</td>';
					subs += '<td class="wdbp-wp-forms-sub">' + sub.date_created + '</td>';
                    subs += '<td class="wdbp-wp-forms-sub">' + sub.ip + '</td>';
					subs += '</tr>';
				});
			}
			$( '#the-list' ).html( subs );
        })
        .fail(function( data ) {
            console.log( "error" );
        });
    }

    get_subs();

    /**
     * Paging
     */
    $( document ).on( 'click', '.page-first', function( e )
    {
        e.preventDefault();
        $( '#wdbp-wp-forms-submissions' ).data( 'offset', 0 );
        on_page();
    });

    $( document ).on( 'click', '.page-prev', function( e )
    {
        e.preventDefault();
        var offset = $( '#wdbp-wp-forms-submissions' ).data( 'offset' );
        var limit = $( '#wdbp-wp-forms-submissions' ).data( 'limit' );
        offset = offset - limit;
        $( '#wdbp-wp-forms-submissions' ).data( 'offset', offset );
        on_page();
    });

    $( document ).on( 'click', '.page-last', function( e )
    {
        e.preventDefault();
        var pages = $( '#wdbp-wp-forms-submissions' ).data( 'pages' );
        var limit = $( '#wdbp-wp-forms-submissions' ).data( 'limit' );
        var offset = ( pages * limit ) - limit;
        $( '#wdbp-wp-forms-submissions' ).data( 'offset', offset );
        on_page();
    });

    $( document ).on( 'click', '.page-next', function( e )
    {
        e.preventDefault();
        var offset = $( '#wdbp-wp-forms-submissions' ).data( 'offset' );
        var limit = $( '#wdbp-wp-forms-submissions' ).data( 'limit' );
        offset = offset + limit;
        $( '#wdbp-wp-forms-submissions' ).data( 'offset', offset );
        on_page();
    });

    function on_page()
    {
        get_subs();
        $( '#wdbp-wp-forms-checkall-subs' ).attr( 'checked', false );
        $( '.wdbp-wp-forms-remove-selected-subs' ).attr('disabled', 'disabled');
    }

    /**
     * View data
     */
    $( document ).on( 'click', '.wdbp-wp-forms-sub', function( e )
    {
        e.preventDefault();
        var id = $( this ).closest( 'tr' ).data( 'id' );

        if( $( "#wdbp-wp-forms-submission-details-" + id ).length )
        {
            $( '.wdbp-wp-forms-submission-details' ).remove();
            return;
        }

        $( '.wdbp-wp-forms-submission-details' ).remove();

        var row = '<tr id="wdbp-wp-forms-submission-details-' + id + '" class="wdbp-wp-forms-submission-details"><th colspan="4"><div class="">Retrieving data ...</div></td></tr>';
        $( this ).closest( "tr" ).after( row );
        var endpoint = $( '#wdbp-wp-forms-submissions' ).data( 'endpoint' );
        var data = {
            action: 'get_sub',
            id: id
        };
        
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            data: data
        })
        .done(function( data ) {
            var sub = JSON.parse( data.sub.data );
            var details = '';
            $.each(sub, function(key, val)
            {
                details += '<strong>' + key + ':</strong> ' + val + '<br>';
            });
            $( '.wdbp-wp-forms-submission-details div' ).html( details );
        })
        .fail(function( data ) {
            console.log( "error" );
        });
    });

    /**
     * Select all rows
     */
    $( document ).on( 'click', '#wdbp-wp-forms-checkall-subs', function( e )
    {
        if( $( this ).is( ':checked' ) )
        {
            $( '.wdbp-wp-forms-remove-sub' ).attr( 'checked', true );
            $( '.wdbp-wp-forms-remove-selected-subs' ).removeAttr('disabled');
        }
        else
        {
            $( '.wdbp-wp-forms-remove-sub' ).attr( 'checked', false );
            $( '.wdbp-wp-forms-remove-selected-subs' ).attr('disabled', 'disabled');
        }
    });

    /**
     * Select row
     */
    $( document ).on( 'click', '.wdbp-wp-forms-remove-sub', function( e )
    {
        $( '#wdbp-wp-forms-checkall-subs' ).attr( 'checked', false );
        var nochecks = true;
        $( '.wdbp-wp-forms-remove-sub' ).each(function(i, el) {
            if( $( this ).is( ':checked' ) )
            {
                nochecks = false;
            }
        });
        if( nochecks == false )
        {
            $( '.wdbp-wp-forms-remove-selected-subs' ).removeAttr('disabled');
        }
        else
        {
            $( '.wdbp-wp-forms-remove-selected-subs' ).attr('disabled', 'disabled');
        }
    });

    /**
     * Remove selected subs
     */
    $( document ).on( 'click', '.wdbp-wp-forms-remove-selected-subs', function( e )
    {
        e.preventDefault();
        tb_show("","#TB_inline?height=150&amp;width=405&amp;inlineId=wdbp-wp-forms-notify-remove-selected&amp;modal=true",null);

    });

    $( document ).on( 'click', '#wdbp-wp-forms-confirm-remove-selected-subs', function( e )
    {
        e.preventDefault();
        $( this ).attr('disabled', 'disabled');
        var subs = [];
        $( '.wdbp-wp-forms-remove-sub' ).each(function(i, el) {
            if( $( this ).is( ':checked' ) )
            {
                subs.push( $( this ).val() );
            }
        });
        var endpoint = $( '#wdbp-wp-forms-submissions' ).data( 'endpoint' );
        var data = {
            action: 'remove_selected_subs',
            subs: subs,
            form: $( '#wdbp-wp-forms-submissions' ).data( 'form' )
        };
        
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            data: data
        })
        .done(function( data ) {
            get_subs();
            var total = data.total;
            var offset = $( '#wdbp-wp-forms-submissions' ).data( 'offset' );
            var limit = $( '#wdbp-wp-forms-submissions' ).data( 'limit' );
            if ( total == 0 )
            {
                window.location.href = "admin.php?page=wdbp_wp_forms";
                return;
            }
            if ( offset >= total )
            {
                offset = offset - limit;
                $( '#wdbp-wp-forms-submissions' ).data( 'offset', offset );
                on_page();
            }
            $( '.wdbp-wp-forms-remove-selected-subs' ).attr('disabled', 'disabled');
            $( '#wdbp-wp-forms-checkall-subs' ).attr( 'checked', false );
            $( '#wdbp-wp-forms-confirm-remove-selected-subs' ).removeAttr('disabled');
            tb_remove();
        })
        .fail(function() {
            console.log( "error" );
        });

    });

    /**
     * Remove all subs
     */
    $( document ).on( 'click', '.wdbp-wp-forms-remove-all-subs', function( e )
    {
        e.preventDefault();
        tb_show("","#TB_inline?height=150&amp;width=405&amp;inlineId=wdbp-wp-forms-notify-remove-all&amp;modal=true",null);

    });

    $( document ).on( 'click', '#wdbp-wp-forms-confirm-remove-all-subs', function( e )
    {
        e.preventDefault();
        $( this ).attr('disabled', 'disabled');
        var endpoint = $( '#wdbp-wp-forms-submissions' ).data( 'endpoint' );
        var data = {
            action: 'remove_all_subs',
            form: $( '#wdbp-wp-forms-submissions' ).data( 'form' )
        };
        
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            data: data
        })
        .done(function( data ) {
            window.location.href = "admin.php?page=wdbp_wp_forms";
        })
        .fail(function() {
            console.log( "error" );
        });

    });

    $( document ).on( 'click', '.wdbp-thickbox-dismiss-button', function( e )
    {
        e.preventDefault();
        tb_remove();
    });


    // Type delay function for search box
    function type_delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    $( document ).on('keyup paste', '#wdbp-wp-forms-search', type_delay(function(event) {
        console.log('Time elapsed!', this.value);
        get_subs();
    }, 500));

});
