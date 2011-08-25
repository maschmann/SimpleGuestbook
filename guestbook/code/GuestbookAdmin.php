<?php
/**
 * guestbookAdmin
 *
 * @author Marc Aschmann <marc (at) aschmann.org>
 * @package guestbook
 * $Id: GuestbookAdmin.php 70 2010-06-03 13:01:15Z maschmann $
 *
 */

/**
 * guestbookAdmin class
 *
 * @author Marc Aschmann <marc (at) aschmann.org>
 *
 */
class GuestbookAdmin extends ModelAdmin
{
	/**
	 * managed models
	 * @var static array
	 */
	public static $managed_models = array(
				'GuestbookEntry',
				'GuestbookEntryComment',
			);

	/**
	 * url segment var
	 * @var static string
	 */
	static $url_segment = 'Guestbook';

}

?>