/**
 * main javascript file
 *
 * @author Marc Aschmann <marc (at) aschmann.org>
 * @package guestbook
 * $Id: guestbook.js 57 2010-03-26 18:16:42Z maschmann $
 *
 */

jQuery.noConflict();

jQuery( document ).ready( function()
{
	try
	{
		var dlg = jQuery( '#popForm' ).dialog( {
			title: 'add comment',
			//height: 318,
			width: 350,
			modal: true,
			position: ['center', 'center'],
			autoOpen: false
		});

		jQuery( 'a.popForm' ).click( function(){
			//dlg.html = '';
			dlg.load( jQuery( this ).attr( 'href' ) );
			dlg.dialog( 'open' );
			return false;
		});

	}
	catch( e )
	{
		console.log( 'document ready error: ' + e );
	}
} );

/**
 * inits a form onClick action with jQuery ajax
 * it's a bit more generic as it needs to be: I'll update
 * the whole guestbook to use ajax soon
 *
 * @param string strFormName
 * @return void
 */
function initForm( strFormName, intEntryID )
{
	try
	{
		switch ( strFormName ) {
			case 'CommentForm':
				var strTarget = '.entryComments_' + intEntryID;
				break;
			default:
				var strTarget = '#FormMessage';
				break;
		}

		var options = {
				target: strTarget
		};

		// bind to the form's submit event
		jQuery( '#Form_' + strFormName ).submit( function()
		{
			jQuery( this ).ajaxSubmit( options );
			jQuery( '#popForm' ).dialog( 'destroy' );
			jQuery( '#popForm' ).dialog( 'close' );
			//console.log( 'target: ' + strTarget );
			return false;
		} );
	}
	catch( e )
	{
		console.log( 'initForm error: ' + e );
	}
}

function reloadComments( intEntryID, strHref )
{
	try
	{
		jQuery( 'div.entryComments_' + intEntryID ).load( strHref );
	}
	catch( e )
	{
		//console.log( 'reloadComments error: ' + e );
	}
}