<?php
/**
 * guestbookAdmin
 *
 * @author Marc Aschmann <marc (at) aschmann.org>
 * @package guestbook
 */

/**
 * guestbookAdmin class
 *
 * @author Marc Aschmann <marc (at) aschmann.org>
 * @package \Guestbook\Admin
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