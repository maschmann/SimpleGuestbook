<?php
/**
 * Guestbook
 * @author Marc Aschmann <marc (at) aschmann.org>
 * @package guestbook
 */

/**
 * Guestbook model
 * @author Marc Aschmann <marc (at) aschmann.org>
 */
class Guestbook extends Page
{

	/**
	 * page icon
	 * @var string
	 */
	static $icon = "/guestbook/img/icons/guestbook";

	/**
	 * array of allowed subelements
	 * @var array
	 */
	static $allowed_children = array();

	/**
	 * name of the page in singular
	 * @var string
	 */
	static $singular_name = 'Guestbook';

	/**
	 * name of the page in plural
	 * @var string
	 */
	static $plural_name = 'Guestbooks';

	/**
	 * properties for entries
	 * @var array
	 */
	static $db = array(
		'EncryptEmail'			=> 'Boolean',
		'NeedsActivation'		=> 'Boolean',
		'ShowPagination'		=> 'Boolean',
		'PaginationLimit'		=> 'Int(3)',
		'SpamProtection'		=> 'Varchar(15)',
		'EntryComments'			=> 'Boolean',
		'ReCaptchaStyle'		=> 'Varchar(15)',
		'ReCaptchaLang'			=> 'Varchar(2)',
		'ShowLastName'			=> 'Boolean',
		'ShowEmail'				=> 'Boolean',
		'ShowHomepage'			=> 'Boolean',
		'ShowLastNameInEntries'	=> 'Boolean',
		'SenderMailAddress' 	=> 'Varchar(255)',
		'ReceiverMailAddress'	=> 'Varchar(255)',
		'EnableSpamBlock'		=> 'Boolean',
		'BlockedMailHosts'		=> 'Text', //needs to be that big
		'ShowEmoticons'			=> 'Boolean',
	);

	/**
	 * default values for entries
	 * @var array
	 */
	static $defaults = array(
		'EncryptEmail'			=> true,
		'NeedsActivation'		=> false,
		'ShowPagination'		=> true,
		'PaginationLimit'		=> 25,
		'SpamProtection'		=> null,
		'EntryComments'			=> false,
		'ReCaptchaStyle'		=> 'clean',
		'ReCaptchaLang'			=> 'en',
		'ShowLastName'			=> true,
		'ShowEmail'				=> true,
		'ShowHomepage'			=> true,
		'ShowLastNameInEntries'	=> true,
		'SenderMailAddress' 	=> '',
		'ReceiverMailAddress'	=> '',
		'EnableSpamBlock'		=> false,
		'BlockedMailHosts'		=> 'mail.ru;gmail.com;yahoo.co.uk;hop.ru;zlocorp.com;chilotickr.com;sof-oem-bug.net;pimpmystick.com;dotandcomm.info;naclub.net',
		'ShowEmoticons'			=> false,
	);

	/**
	 * 1:n database relation
	 * @var array
	 */
	static $has_many = array(
		'GuestbookEntries'	=> 'GuestbookEntry',
	);

	/**
	 * emoticons for guestbook
	 * @var array
	 */
	static $arrEmoticons = array();

	/**
	 * retrieve the entries for current category
	 * @param void
	 * @return object Fieldset
	 */
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$arrTabFields = array();

		$encryptMailField = new CheckboxField(
			'EncryptEmail',
			_t( 'Guestbook.ENCRYPTMAIL', 'Encrypt eMail addresses (needs javascript)' )
		);

		$needsActivationField = new CheckboxField(
			'NeedsActivation',
			_t( 'Guestbook.NEEDSACTIVATION', 'New entries need activation' )
		);

		$entryCommentsField = new CheckboxField(
			'EntryComments',
			_t( 'Guestbook.ENTRYCOMMENTS', 'Allow comments for entries' )
		);

		$enableSpamBlockField = new CheckboxField(
			'EnableSpamBlock',
			_t( 'Guestbook.SPAMBLOCK', 'Enables Spam blocking by host and links in GB text' )
		);

		$spamProtectionField = new DropdownField(
			'SpamProtection',
			_t( 'Guestbook.SPAMPROTECTION', 'Which spamprotection?' ),
			array(
				null			=> '-',
				'recaptcha'		=> 'ReCaptcha',
				'phpcaptcha'	=> 'PHPCaptcha',
				'simplestspam'	=> 'SimplestSpam',
				'mathspam'		=> 'MathSpamProtection',
			)
		);

		$showPaginationField = new CheckboxField(
			'ShowPagination',
			_t( 'Guestbook.SHOWPAGINATION', 'Show Pagination for entries' )
		);

		$showLastNameField = new CheckboxField(
			'ShowLastName',
			_t( 'Guestbook.SHOWLASTNAME', 'Show "last name" field in guestbook form' )
		);

		$showEmailField = new CheckboxField(
			'ShowEmail',
			_t( 'Guestbook.SHOWEMAIL', 'Show "email" field in guestbook form' )
		);

		$showHomepageField = new CheckboxField(
			'ShowHomepage',
			_t( 'Guestbook.SHOWHOMEPAGE', 'Show "homepage" field in guestbook form' )
		);

		$showLastNameInEntriesField = new CheckboxField(
			'ShowLastNameInEntries',
			_t( 'Guestbook.SHOWLASTNAMEINENTRIES', 'Show "last name" in entries' )
		);
		
		$senderMailaddress = new TextField(
			'SenderMailAddress',
			_t( 'Guestbook.SENDERMAILADDRESS', 'Where to send receipt mail for new entries' )
		);
		
		$receiverMailaddress = new TextField(
			'ReceiverMailAddress',
			_t( 'Guestbook.RECEIVERMAILADDRESS', 'Where to send receipt mail for new entries' )
		);

		$blockedMailHostsField = new TextField(
			'BlockedMailHosts',
			_t( 'Guestbook.BLOCKEDMAILHOSTSFIELD', 'Block mail hosts (spammers etc.), syntax: mail.ru;gmail.com' )
		);

		$showEmoticonsField = new CheckboxField(
			'ShowEmoticons',
			_t( 'Guestbook.SHOWEMOTICONS', 'Show emoticons in entries' )
		);


		$arrTabFields = array(
			$senderMailaddress,
			$receiverMailaddress,
			$encryptMailField,
			$needsActivationField,
			$entryCommentsField,
			$showLastNameInEntriesField,
			$showPaginationField,
			$showLastNameField,
			$showEmailField,
			$showHomepageField,
			$spamProtectionField,
			$enableSpamBlockField,
			$blockedMailHostsField,
			$showEmoticonsField,
		);

		// if pagination is enabled, show limits
		if( 1 == (int)$this->ShowPagination )
		{
			$paginationLimitField = new DropdownField(
				'PaginationLimit',
				_t( 'Guestbook.PAGNATIONLIMIT', 'Entries per page' ),
				array(
					null => '-',
					15 => '15',
					20 => '20',
					25 => '25',
					30 => '30',
				)
			);

			$arrTabFields[] = $paginationLimitField;
		}

		// if we've got ReCaptcha enabled, we show styling options
		if( 'recaptcha' == $this->SpamProtection )
		{
			$ReCaptchaStyleField = new DropdownField(
				'ReCaptchaStyle',
				_t( 'Guestbook.RECAPTCHASTYLE', 'ReCaptcha Style' ),
				array(
					'custom'		=> 'custom',
					'clean'			=> 'clean',
					'red'			=> 'red',
					'blackglass'	=> 'blackglass',
					'white'			=> 'white',
				)
			);

			$ReCaptchaLangField = new DropdownField(
				'ReCaptchaLang',
				_t( 'Guestbook.RECAPTCHALANG', 'ReCaptcha language (only works if i18n is not set!)' ),
				array(
					'en'	=> 'en',
					'de'	=> 'de',
					'fr'	=> 'fr',
					'nl'	=> 'nl',
					'pt'	=> 'pt',
					'ru'	=> 'ru',
					'es'	=> 'es',
					'tr'	=> 'tr',
				)
			);

			$arrTabFields[]	= $ReCaptchaStyleField;
			$arrTabFields[]	= $ReCaptchaLangField;
		}

		$fields->addFieldsToTab( 'Root.Content.' . _t( 'Guestbook.TABNAMECONFIG', 'Config' ), $arrTabFields );

		$entriesTable = new DataObjectManager(
 			$this,				// controller object
 			'GuestbookEntries',	// fieldname
 			'GuestbookEntry',	// dataObject class
			array(				// fields for overview
				'FirstName'	=> _t( 'GuestbookEntry.FIRSTNAME', 'First Name' ),
				'LastName'	=> _t( 'GuestbookEntry.LASTNAME', 'Last Name' ),
				'Email'		=> _t( 'GuestbookEntry.EMAIL', 'Email' ),
				'Title'		=> _t( 'GuestbookEntry.TITLE', 'Title' ),
				'Comment'	=> _t( 'GuestbookEntry.COMMENT', 'Comment' ),
				'IsSpam'	=> _t( 'GuestbookEntry.ISSPAM', 'Is Spam?' ),
				'IsActive'	=> _t( 'GuestbookEntry.ISACTIVE', 'Is activated?' ),
			),
			'getCMSFields'		// fields for popup
		);

		$fields->addFieldsToTab( 'Root.Content.' . _t( 'Guestbook.TABNAME', 'Entries' ), array( $entriesTable ) );

		return $fields;
	}

	/**
	 * set emoticon codes and aliases as static array for later use
	 * @param type array
	 * @return void
	 */
	public static function setEmoticons( $arrEmoticons )
	{
		$arrResult = array();
		foreach( $arrEmoticons as $strKey => $strValue)
		{
			$arrResult[ $strKey ] = "<img src=\"guestbook/img/emoticons/" . $strValue . ".gif\" alt=\"" . $strValue . "\" class=\"emoticon\"/>";
		}

		self::$arrEmoticons = $arrResult;
	}

	/**
	 * get defined emoticon array
	 * @return type array
	 */
	public static function getEmoticons()
	{
		return self::$arrEmoticons;
	}


	/**
	 * replace emoticons in entry
	 * @param type string
	 * @return type string
	 */
	public static function getReplaceEmoticons( $strEntry )
	{
		/**
		 * get configured emoticons
		 */
		$arrEmoticons = Guestbook::getEmoticons();

		/**
		 * replace all emoticons with the appropriate images
		 */
		$strEntry = str_replace(
			array_keys( $arrEmoticons ),
			array_values( $arrEmoticons ),
			$strEntry
		);

		return $strEntry;
	}

	/**
	 * simple method to mask eMail addresses
	 *
	 * source web site: http://www.pgregg.com/projects/
	 * You must also make this original source code available for download
	 * unmodified or provide a link to the source.  Additionally you must provide
	 * the source to any modified or translated versions or derivatives.
	 *
	 * $arrParam = array(
	 *		'FirstName'	=> string
	 *		'LastName'	=> string
	 *	 	'Email'		=> string
	 *		'ShowLastNameInEntries' => boolean
	 * );
	 *
	 * @param array arrParam
	 * @return string complete mail link with javascript
	 */
	public static function getEmailLink( $arrParam = array() )
	{
		$strMailLink	= preg_replace( "/[;,]/", "", $arrParam[ 'Email' ] );
		$strMailLetters	= '';
		$strFirstname	= Convert::raw2xml( strip_tags( $arrParam[ 'FirstName' ] ) );
		$strLastName	= '';
		if( isset( $arrParam[ 'ShowLastNameInEntries' ] )
				&& true == $arrParam[ 'ShowLastNameInEntries' ]
			)
		{
			$strLastName	= Convert::raw2xml( strip_tags( $arrParam[ 'LastName' ] ) );
		}
		$strUserName	= $strFirstname . ' ' . $strLastName;
		$arrResult		= array();
		$retVal			= $strUserName;

		if( array_key_exists( 'Email', $arrParam )
			&& null != $arrParam[ 'Email' ]
			)
		{

			$strMailLink = '<a href="mailto:' . $strMailLink . '" title="' . $strUserName . '">' . $strUserName . '</a>';
		    for ( $i = 0; $i < strlen( $strMailLink ); $i ++ )
		    {
			    $l = substr( $strMailLink, $i, 1 );
			    if (strpos( $strMailLetters, $l ) === false)
			    {
			        $p = rand( 0, strlen( $strMailLetters ) );
			        $strMailLetters = substr( $strMailLetters, 0, $p ) .
			          $l . substr( $strMailLetters, $p, strlen( $strMailLetters ) );
			    }
		    }

		    $strMailLettersEnc = str_replace( "\\", "\\\\", $strMailLetters );
		    $strMailLettersEnc = str_replace( "\"", "\\\"", $strMailLettersEnc );

		    $strMailIndexes = '';
		    for ( $i = 0; $i < strlen( $strMailLink ); $i ++ )
		    {
			    $index = strpos( $strMailLetters, substr( $strMailLink, $i, 1 ) );
			    $index += 48;
			    $strMailIndexes .= chr( $index );
		    }
		    $strMailIndexes = str_replace( "\\", "\\\\", $strMailIndexes );
		    $strMailIndexes = str_replace( "\"", "\\\"", $strMailIndexes );

			$arrResult[] = '<script type="text/javascript">';
			$arrResult[] = '/* <![CDATA[ */';
			$arrResult[] = '	ML="' . $strMailLettersEnc . '";';
			$arrResult[] = '	MI="' . $strMailIndexes . '";';
			$arrResult[] = '	OT="";';
			$arrResult[] = '	for(j=0;j<MI.length;j++){';
			$arrResult[] = '	OT+=ML.charAt(MI.charCodeAt(j)-48);';
			$arrResult[] = '	}document.write(OT);';
			$arrResult[] = '/* ]]> */';
			$arrResult[] = '</script>';
			$arrResult[] = '<noscript>Sorry, you need javascript to view this email address</noscript>';

			$retVal = implode( "\n", $arrResult );
		}

		return $retVal;
	}

}

/**
 * page controller
 * @author Marc Aschmann <marc (at) aschmann.org>
 */
class Guestbook_Controller extends Page_Controller implements PermissionProvider
{

	/**
	 * overwrites the global init() method
	 * I just use it to add CSS styling and JS support
	 * @return void
	 */
	function init()
	{
		parent::init();

		//add jQuery support
		Requirements::javascript( THIRDPARTY_DIR . '/jquery/jquery-packed.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-ui/minified/jquery.ui.core.min.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-ui/minified/jquery.ui.widget.min.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-ui/minified/jquery.ui.mouse.min.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-ui/minified/jquery.ui.button.min.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-ui/minified/jquery.ui.position.min.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-ui/minified/jquery.ui.draggable.min.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-ui/minified/jquery.ui.resizable.min.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-ui/minified/jquery.ui.dialog.min.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-livequery/jquery.livequery.js' );
		Requirements::javascript( THIRDPARTY_DIR . '/jquery-form/jquery.form.js' );
		Requirements::css( THIRDPARTY_DIR . '/jquery-ui-themes/base/jquery.ui.all.css' );

		// Add guestbook module js support
		Requirements::javascript( 'guestbook/javascript/guestbook.js');

		// check if there's an overriding css file
		Requirements::css( 'guestbook/css/guestbook.css' );

		/**
		 * this allows to have only the overridden styles in one file. And no
		 * more merging after a new version with css changes is released ;-)
		 * careful: One more request will be made until you enable the css
		 * file merge ( http://doc.silverstripe.org/recipes:combining_files )
		 */
		if( Director::fileExists( project() . '/css/guestbook.css' ) )
		{
			Requirements::css( project() . '/css/guestbook.css' );
		}

	}
	
    /**
     * provides permissions for the adminstration of the guestbook
     * @return array
     */
    function providePermissions()
    {
        return array(
            "GUESTBOOK_DELETEENTRY" => "User is allowed to delete comments",
            "GUESTBOOK_DELETECOMMENT" => "User is allowed to delete sub-comments",
            "GUESTBOOK_ADDCOMMENT" => "User is allowed to add sub-comments",
            "GUESTBOOK_CHANGECOMMENTSTATE" => "User is allowed to mark items as spam or activate items",
        );
    }

	/**
	 * creates a new entry form
	 * @return object form
	 */
	public function Form()
	{
		$fields = singleton( 'GuestbookEntry' )->getCMSFields();
		if( is_object( $fields ) )
		{

			 // remove "admin" fields
			$fields->removeByName( 'IsActive' );
			$fields->removeByName( 'IsSpam' );

			/**
			 * checks for various fields display
			 */
			if( false == $this->ShowLastName )
			{
				$fields->removeByName( 'LastName' );
			}

			if( false == $this->ShowEmail )
			{
				$fields->removeByName( 'Email' );
			}

			if( false == $this->ShowHomepage )
			{
				$fields->removeByName( 'Url' );
			}

			if( MathSpamProtection::isEnabled()
				&& 'mathspam' == $this->SpamProtection )
			{
				$fields->push( new TextField( 'Math',
						sprintf( _t( 'Guestbook.SPAMQUESTION', "Spam protection question: %s" ), MathSpamProtection::getMathQuestion() )
					)
				);
			}
		}

		$actions = new FieldSet(
			new FormAction( 'doSubmitEntry', _t( 'Guestbook.ENTER', 'Enter' ) )
		);
		$validator = new RequiredFields(
			'FirstName',
			'Comment'
		);
		$form = new Form(
			$this,
			'Form',
			$fields,
			$actions,
			$validator
		);

		// add spamprotection if enabled
		if( ( 'recaptcha' == $this->SpamProtection
				&& 'RecaptchaProtector' == SpamProtectorManager::get_spam_protector() )
			|| ( 'simplestspam' == $this->SpamProtection
				&& 'SimplestSpamProtector' == SpamProtectorManager::get_spam_protector() )
			||('phpcaptcha' == $this->SpamProtection
			    && 'PhpCaptchaProtector' == SpamProtectorManager::get_spam_protector() )
			)
		{
			SpamProtectorManager::update_form( $form, 'Captcha', array(), _t('Guestbook.CaptchaMessage', 'Captcha') );
		}

		return $form;
	}

	/**
	 * creates a new entry comment form
	 *
	 * @return form object
	 */
	public function commentForm()
	{
		$fields = singleton( 'GuestbookEntryComment' )->getCMSFields();

		$actions = new FieldSet(
			new FormAction( 'doSubmitComment', _t( 'Guestbook.ENTER', 'Enter' ) )
		);
		$validator = new RequiredFields(
			'Comment'
		);
		$form = new Form(
			$this,
			'CommentForm',
			$fields,
			$actions,
			$validator
		);

		return $form;
	}

	/**
	 * submit form data
	 * @param $data form data array
	 * @param $form form object
	 * @return void
	 */
	public function doSubmitEntry( $data, $form )
	{

		$entry			= new GuestbookEntry();
		$blnIsBlocked	= false;

		// if logged-in member, we assume the post is OK
		if( false == ( int )$this->NeedsActivation
			|| true == Member::currentUser() )
		{
			$IsActive = 1;
		}
		else
		{
			$IsActive = 0;
		}

		$form->saveInto( $entry );

		 // entered values validation
		if( !$this->isValidMail( $entry->Email ) )
		{
			$entry->Email	= null;
		}

		$entry->Url	= $this->checkUrl( $entry->Url );

		// override some values
		$entry->GuestbookID = $this->ID;
		$entry->IsActive = ( int )$IsActive;

		// if spamblocking is enabled, check email and text for blocked content
		if( true == $this->EnableSpamBlock )
		{
			if( true == $this->isBlockedHost( $entry->Email )
					|| true == $this->isSpamText( $entry->Comment )
				)
			{
				$blnIsBlocked = true;
			}
		}

		if( false == $blnIsBlocked )
		{
			$entry->write();
			$form->sessionMessage(
				_t( 'Guestbook.ENTRYADDED', 'Entry succesfully created!' ),
				'good'
			);
		}
		else
		{
			$form->sessionMessage(
				_t( 'Guestbook.ENTRYBLOCKED', 'This email is supposed to be spam-related. Please verify if it is correct' ),
				'error'
			);
		}

		Director::redirectBack();
		return;
	}

	/**
	 * submit form data
	 * @param $data form data array
	 * @param $form form object
	 * @return void
	 */
	public function doSubmitComment( $data, $form )
	{
		$retVal = '';

		if( is_numeric( $data[ 'EntryID' ] ) )
		{
			$comment = new GuestbookEntryComment();

			$form->saveInto( $comment );

			// override some values
			$comment->GuestbookEntryID = (int)$data[ 'EntryID' ];
			$comment->write();

			if( Director::is_ajax() )
			{
				$objEntryCommentList = singleton( 'GuestbookEntryComment' );
				$objResult = $objEntryCommentList->getCommentsByEntryID( $data[ 'EntryID' ] );

				$retVal = $this->customise( array(
					'EntryCommentList' => $objResult,
				) )->renderWith( 'Guestbook_entryComments' );
			}
			else
			{
				$form->sessionMessage(
					_t( 'Guestbook.COMMENTADDED', 'Comment succesfully created!' ),
					'good'
				);

				Director::redirectBack();
			}
		}

		return $retVal;
	}

	/**
	 * generate a list of guestbook entries for the page
	 * @return dataObject
	 */
	public function EntryList()
	{
		// pagination stuff
		$limit_start	= '';
		$limit_end		= '';
		if( 1 === ( int )$this->ShowPagination )
		{
			if( !isset( $_GET[ 'start' ] )
				|| !is_numeric( $_GET['start'] )
				|| ( int )$_GET[ 'start' ] < 1)
			{
				$_GET['start'] = 0;
			}

			// set standard pagination value if none is set
			if( !isset( $this->PaginationLimit )
				|| !is_numeric( $this->PaginationLimit )
				|| 0 == $this->PaginationLimit )
			{
				$this->PaginationLimit = 25;
			}

			$limit_start = ( int )$_GET['start'];
			$limit_end = $this->PaginationLimit;
		}

		// now get the entries and comments
		$arrParam = array();
		$arrParam[ 'filter' ]		= 'IsActive = 1 AND IsSpam = 0 AND GuestbookID =' . $this->ID;
		$arrParam[ 'sort' ]			= 'Created DESC';
		$arrParam[ 'limit_start' ]	= $limit_start;
		$arrParam[ 'limit_end' ]	= $limit_end;
		$arrParam[ 'comments' ]		= $this->EntryComments;
		$arrParam[ 'cryptmail' ]	= $this->EncryptEmail;
		$arrParam[ 'emoticons' ]	= $this->ShowEmoticons;
		$objGuestbookEntries = singleton( 'GuestbookEntry' );

		return $objGuestbookEntries->getEntryList( $arrParam );
	}

	/**
	 * request handler, reacts on url params
	 * @return void
	 */
	public function doAction()
	{
		$strType = $this->requestParams[ 'do' ];
		$retVal = '';

		switch ( $strType )
		{
			case 'deleteEntry':
				if( Permission::check('GUESTBOOK_DELETEENTRY') != false )
				{
					DataObject::delete_by_id( 'GuestbookEntry', Controller::curr()->urlParams['ID'] );
					$objEntryComments = singleton( 'GuestbookEntryComment' );
					$objEntryComments->deleteCommentsByEntryID( Controller::curr()->urlParams['ID'] );
				}
				break;
			case 'deleteComment':
				if( Permission::check('GUESTBOOK_DELETECOMMENT' ) != false )
				{
					DataObject::delete_by_id( 'GuestbookEntryComment', Controller::curr()->urlParams['ID'] );
				}
				break;
			case 'addComment':
				if( Permission::check('GUESTBOOK_ADDCOMMENT') != false )
				{
					$retVal = $this->customise( array(
						'EntryID' => Controller::curr()->urlParams['ID'],
					) )->renderWith( 'Guestbook_addComment' );
				}
				break;
			case 'showSmilies':
				// rearrange smilies array for template
				foreach( Guestbook::getEmoticons()  as $strKey => $strValue )
				{
					$arrSmilies[] = array( 
						'Img'	=> $strValue,
						'Code'	=> $strKey,
					);
				}

				$retVal = $this->customise( array(
					'smiliesMap' => new DataObjectSet( $arrSmilies ),
				) )->renderWith( 'Guestbook_showSmilies' );
				break;
			case 'spam':
			case 'activate':
				if( Permission::check('GUESTBOOK_CHANGECOMMENTSTATE') != false )
				{
					$entry = DataObject::get_by_id( 'GuestbookEntry', Controller::curr()->urlParams['ID'] );
					if( $entry )
					{
						if( 'spam' == $strType )
						{
							$entry->IsSpam = 1;
						}
						elseif( 'activate' == $strType )
						{
							$entry->IsActive = 1;
						}
						$entry->write();
					}
				}
				break;
		}
		if( Director::is_ajax() )
		{
			return $retVal;
		}
		else
		{
			Controller::curr()->redirectBack();
		}
	}

	/**
	 * create spam protection config javascript
	 *
	 * @return type string
	 */
	public function SpamProtectionOptions()
	{
		$retVal = array();

		/**
		 * add JS options if ReCaptcha active
		 */
		if( 'recaptcha' == $this->SpamProtection )
		{
			if( 'en_US' != i18n::get_locale() )
			{
				$arrLang = array(
					'en',
					'nl',
					'fr',
					'de',
					'pt',
					'ru',
					'es',
					'tr',
				);

				$strLang = substr( i18n::get_locale(), 0, 2 );
				if( false == in_array( $strLang, $arrLang ) )
				{
					$strLang = 'en';
				}
			}
			else // if i18n is not other than 'en_EN'
			{
				$strLang = $this->ReCaptchaLang;
			}

			$retVal[]	= '<script type="text/javascript">';
			$retVal[]	= '/* <![CDATA[ */';
			$retVal[]	= '	var RecaptchaOptions = {';
			$retVal[]	= '		theme : \'' . $this->ReCaptchaStyle . '\',';
			$retVal[]	= '		lang : \'' . $strLang . '\'';
			$retVal[]	= '	};';
			$retVal[]	= '/* ]]> */';
			$retVal[]	= '</script>';

		}

		return implode( "\n", $retVal );
	}

	/**
	 * sanity check for eMail adresses
	 *
	 * @param string $strEmail
	 * @return bool
	 */
	private function isValidMail( $strEmail )
	{
		$retVal = false;
		if( preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $strEmail ) )
		{
			list( $username, $strDomain ) = split( '@' , $strEmail );

			if( checkdnsrr( $strDomain,'MX' ) )
			{
				$retVal = true;
			}
		}

		return $retVal;
	}

	/**
	 * check if submitted mail address is in blocked hosts list
	 * @param string $strEmail
	 */
	private function isBlockedHost( $strEmail )
	{
		// remove whitespaces & excape dots
		$strHosts	= str_replace( ' ' , '', $this->BlockedMailHosts );
		$strHosts	= str_replace( '.' , '\\.', $this->BlockedMailHosts );
		$blnReturn	= false;

		if( '' != $strHosts )
		{
			$arrHosts = explode( ';', $strHosts );

			foreach ( $arrHosts as $strHost )
			{
				if( true == preg_match( '/'. $strHost .'/' , $strEmail ) )
				{
					$blnReturn = true;
					break; //exit loop on first occurance
				}
			}
		}

		return $blnReturn;
	}

	/**
	 * Check if text contains hyperlinks
	 *
	 * @param string $strText
	 * @param boolean $blnCaseSensitive
	 * @return boolean
	 */
	private function isSpamText( $strText, $blnCaseSensitive=false )
	{
		$blnReturn		= false;
		$arrHostmasks	= array(
			'http:\/\/',
			'https:\/\/',
		);

		if( false == $blnCaseSensitive )
		{
			$strText = strtolower( $strText );
		}

		foreach ( $arrHostmasks as $strHostmask )
		{
			if( true == preg_match( '/'. $strHostmask .'/' , $strText ) )
			{
				$blnReturn = true;
				break; //exit loop on first occurance
			}
		}

		return $blnReturn;
	}

	/**
	 * simple url check
	 *
	 * @param string $strUrl
	 * @return string $strUrl
	 */
	private function checkUrl( $strUrl )
	{
		/**
		 * check given URL for http/https
		 */
		$pattern = "/^((https?|ftp)\:\/\/)?"; // scheme
		$pattern .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // host or ip
		$pattern .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // path
		$pattern .= "(#[a-z_.-][a-z0-9+\$_.-]*)?$/"; // domain

		$validUrl = preg_match( $pattern, $strUrl, $matches );

		if( isset( $matches[ 1 ] )
			&& '' == $matches[ 1 ]
			&& '' != $matches[ 3 ] // path
			&& '' != $matches[ 4 ] // domain
			)
		{
			$strUrl = 'http://' . $strUrl;
		}
		elseif( false == isset( $matches[ 1 ] ) ) //skip invalid url
		{
			$strUrl = null;
		}

		return $strUrl;
	}


	/*
	 * rights management
	 *
	 **********************************************************/

	/**
	 * check if current logged in user is an admin
	 *
	 * @return boolean
	 */
	public function isAdmin()
	{
		$member = Member::currentUser();
		$retVal = false;

		if( Permission::checkMember( $member, 'ADMIN' ) )
		{
			$retVal = true;
		}

		return $retVal;
	}

	/**
	 * wraps logged in user check
	 * don't know why this does not work...
	 *
	 * @return boolean
	 */
	public function CurrentUser()
	{
		return Member::currentUser();
	}

}
?>