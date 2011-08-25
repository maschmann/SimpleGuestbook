<?php
/**
 * german (germany) language pack
 *
 * @package guestbook
 * @author Marc Aschmann <marc (at) aschmann.org>
 * $Id: de_DE.php 96 2011-08-04 10:21:57Z maschmann $
 */

i18n::include_locale_file( 'guestbook', 'de_DE' );

global $lang;

if( array_key_exists( 'de_DE', $lang ) && is_array( $lang[ 'de_DE' ] ) )
{
	$lang[ 'de_DE' ] = array_merge( $lang[ 'de_DE' ], $lang[ 'de_DE' ] );
}
else
{
	$lang[ 'de_DE' ] = $lang[ 'de_DE' ];
}

$lang['de_DE']['Guestbook']['CAPTCHAMESSAGE'] = 'Captcha';
$lang['de_DE']['Guestbook']['COMMENTADDED'] = 'Comment succesfully created!';
$lang['de_DE']['Guestbook']['ENCRYPTMAIL'] = 'Mails verschlüsseln (benötigt Javascript)';
$lang['de_DE']['Guestbook']['ENTER'] = 'Eintragen';
$lang['de_DE']['Guestbook']['ENTRYADDED'] = 'Eintrag erfolgreich angelegt!';
$lang['de_DE']['Guestbook']['ENTRYCOMMENTS'] = 'Erlaube Kommentare für Einträge';
$lang['de_DE']['Guestbook']['NEEDSACTIVATION'] = 'Neue Einträge müssen aktiviert werden';
$lang['de_DE']['Guestbook']['PAGNATIONLIMIT'] = 'Einträge pro Seite';
$lang['de_DE']['Guestbook']['PLURALNAME'] = array(
	'Gästebücher',
	50,
	'Pural name of the object, used in dropdowns and to generally identify a collection of this object in the interface'
);
$lang['de_DE']['Guestbook']['RECAPTCHALANG'] = 'ReCaptcha sprache (nur aktiv wenn i18n nicht gesetzt ist!)';
$lang['de_DE']['Guestbook']['RECAPTCHASTYLE'] = 'ReCaptcha Style';
$lang['de_DE']['Guestbook']['SHOWPAGINATION'] = 'Paging anzeigen';
$lang['de_DE']['Guestbook']['RECEIVERMAILADDRESS'] = 'Bestätigungsmail(adresse) für neuen Eintrag (gesetzt == aktiviert!)';
$lang['de_DE']['Guestbook']['SHOWEMAIL'] = 'Zeige "email" Feld im Formular';
$lang['de_DE']['Guestbook']['SHOWHOMEPAGE'] = 'Zeige "homepage" Feld im Formular';
$lang['de_DE']['Guestbook']['SHOWLASTNAME'] = 'Zeige "Nachname" Feld im Formular';
$lang['de_DE']['Guestbook']['SHOWLASTNAMEINENTRIES'] = 'Zeige "Nachname" in Einträgen';
$lang['de_DE']['Guestbook']['SHOWPAGINATION'] = 'Zeige Paging für Einträge';
$lang['de_DE']['Guestbook']['SINGULARNAME'] = array(
	'Gästebuch',
	50,
	'Singular name of the object, used in dropdowns and to generally identify a single object in the interface'
);
$lang['de_DE']['Guestbook']['SPAMPROTECTION'] = 'Welcher Spamschutz?';
$lang['de_DE']['Guestbook']['SPAMQUESTION'] = 'Spamschutz Frage: %s';
$lang['de_DE']['Guestbook']['TABNAME'] = 'Einträge';
$lang['de_DE']['Guestbook']['TABNAMECONFIG'] = 'Config';
$lang['de_DE']['Guestbook.ss']['COMMENTSTITLE'] = 'Kommentare:';
$lang['de_DE']['Guestbook.ss']['DELCOMMENT'] = 'Kommentar löschen';
$lang['de_DE']['Guestbook.ss']['DELENTRY'] = 'Eintrag löschen';
$lang['de_DE']['Guestbook.ss']['ENTRYISSPAM'] = 'Eintrag ist Spam';
$lang['de_DE']['Guestbook.ss']['FROM'] = 'von';
$lang['de_DE']['Guestbook.ss']['HOMEPAGE'] = 'Homepage';
$lang['de_DE']['Guestbook.ss']['NEWCOMMENT'] = 'Eintrag kommentieren';
$lang['de_DE']['Guestbook.ss']['NEXT'] = 'vor';
$lang['de_DE']['Guestbook.ss']['NEXTPAGE'] = 'Nächste Seite';
$lang['de_DE']['Guestbook.ss']['NOENTRIESYET'] = 'Noch keine Einträge';
$lang['de_DE']['Guestbook.ss']['PREVIOUS'] = 'zurück';
$lang['de_DE']['Guestbook.ss']['PREVIOUSPAGE'] = 'Vorherige Seite';
$lang['de_DE']['Guestbook.ss']['VIEWPAGENO'] = 'Seite Nummer';
$lang['de_DE']['GuestbookEntry']['COMMENT'] = 'Kommentar';
$lang['de_DE']['GuestbookEntry']['EMAIL'] = 'Email';
$lang['de_DE']['GuestbookEntry']['FIRSTNAME'] = 'Vorname';
$lang['de_DE']['GuestbookEntry']['ISACTIVE'] = 'Ist aktiv?';
$lang['de_DE']['GuestbookEntry']['ISSPAM'] = 'Ist Spam?';
$lang['de_DE']['GuestbookEntry']['LASTNAME'] = 'Nachname';
$lang['de_DE']['GuestbookEntry']['LINKTEXT'] = '#Eintrag';
$lang['de_DE']['GuestbookEntry']['MAILSUBJECT'] = 'Neuer Gästebucheintrag :-)';
$lang['de_DE']['GuestbookEntry']['PLURALNAME'] = array(
	'GuestbookEntries',
	50,
	'Pural name of the object, used in dropdowns and to generally identify a collection of this object in the interface'
);
$lang['de_DE']['GuestbookEntry']['SINGULARNAME'] = array(
	'GästebuchEintrag',
	50,
	'Singular name of the object, used in dropdowns and to generally identify a single object in the interface'
);
$lang['de_DE']['GuestbookEntry']['TITLE'] = 'Titel';
$lang['de_DE']['GuestbookEntry']['URL'] = 'Homepage';
$lang['de_DE']['GuestbookEntryComment']['PLURALNAME'] = array(
	'GuestbookEntryComments',
	50,
	'Pural name of the object, used in dropdowns and to generally identify a collection of this object in the interface'
);
$lang['de_DE']['GuestbookEntryComment']['SINGULARNAME'] = array(
	'GuestbookEntryComment',
	50,
	'Singular name of the object, used in dropdowns and to generally identify a single object in the interface'
);
$lang['de_DE']['Guestbook_addComment.ss']['NOTLOGGEDIN'] = 'Sie sind nicht eingeloggt!';

?>