<?php
/**
 * standard config file
 * @author Marc Aschmann <marc (at) aschmann.org>
 * @package guestbook
 */

/**
 * set spam protection to ReCaptcha module
 * notice: you will have to install ReCaptcha and SpamProtector modules!
 */
//SpamProtectorManager::set_spam_protector("RecaptchaProtector");
//SpamProtectorManager::set_spam_protector("SimplestSpamProtector");
SpamProtectorManager::set_spam_protector("PHPCaptchaProtector");

/**
 * enable translations
 */
i18n::set_locale('en_US');

/**
 * enable spam Protection
 */
MathSpamProtection::setEnabled();

Guestbook::setEmoticons( array(
	':-)'		=> 'smile',
	':)'		=> 'smile',
	':-('		=> 'sad',
	':('		=> 'sad',
	';-)'		=> 'wink',
	';)'		=> 'wink',
	':-D'		=> 'biggrin',
	':D'		=> 'biggrin',
	':P'		=> 'razz',
	':-P'		=> 'razz',
	'B)'		=> 'cool',
	'B-)'		=> 'cool',
	':rofl:'	=> 'lol',
	':eek:'		=> 'eek',
	':lol:'		=> 'lol',
	':evil:'	=> 'evil',
	':mad:'		=> 'mad',
	':sad:'		=> 'sad',
) );

?>