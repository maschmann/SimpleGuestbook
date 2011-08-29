<?php
/**
 * GuestbookEntry
 * @author Marc Aschmann <marc (at) aschmann.org>
 * @package guestbook
 */


/**
 * GuestbookEntry model
 * @author Marc Aschmann <marc (at) aschmann.org>
 */
class GuestbookEntry extends DataObject
{

	/**
	 * indicates, if this is a new (not already existent in database) object
	 * @var bool
	 */
	private $new = false;

	/**
	 * name of the object in singular
	 * @var string
	 */
	static $singular_name = 'GuestbookEntry';

	/**
	 * name of the object in singular
	 * @var string
	 */
	static $plural_name = 'GuestbookEntries';

	/**
	 * database column definitions
	 * @var array
	 */
	static $db = array(
		'FirstName'	=> 'Varchar(50)',	// poster's first name
		'LastName'	=> 'Varchar(50)',	// poster's last name
		'Email'		=> 'Varchar(255)',	// poster's mail address
		'Title'		=> 'Varchar(255)',	// title for the entry
		'Comment'	=> 'HTMLText',			// the actual entry
		'Url'		=> 'Varchar(255)',	// an URL set by the poster
		'IsSpam'	=> 'Boolean',		// spamflag
		'IsActive'	=> 'Boolean',		// if set active
		'AuthorID'	=> 'Int(11)',		// ID of user, if logged in
	);

	/**
	 * default values for database fields
	 * @var array
	 */
	static $defaults = array(
		'AuthorID'	=> null
	);

	/**
	 * fields searchable via backend
	 * since this is backend we don't need any restrictions yet
	 * @var static array
	 */
	static $searchable_fields = array(
		'FirstName',
		'LastName',
		'Email',
		'Title',
		'Comment',
		'Url',
		'IsSpam',
		'IsActive',
	);

	/**
	 * fields for model admin search results
	 * @var array
	 */
	static $summary_fields = array(
		'FirstName',
		'LastName',
		'Title',
		'IsSpam',
		'IsActive',
	);

	/**
	 * database has_one relation
	 * @var array
	 */
	static $has_one = array(
		'Guestbook'	=> 'Guestbook',
	);

	/**
	 * message 1:n relations
	 * @var array
	 */
	static $has_many = array(
		'GuestbookEntryComments'	=> 'GuestbookEntryComment',
	);

	/**
	 * definition of form fields for guestbook entries
	 * @param void
	 * @return object FieldSet
	 */
	public function getCMSFields()
	{
		$fields = new FieldSet(
			new TextField( 'FirstName', _t( 'GuestbookEntry.FIRSTNAME', 'First Name' ) ),
			new TextField( 'LastName', _t( 'GuestbookEntry.LASTNAME', 'Last Name' ) ),
			new EmailField( 'Email', _t( 'GuestbookEntry.EMAIL', 'Email' ) ),
			new TextField( 'Title', _t( 'GuestbookEntry.TITLE', 'Title' ) ),
			new TextareaField( 'Comment', _t( 'GuestbookEntry.COMMENT', 'Comment' ) ),
			new TextField( 'Url', _t( 'GuestbookEntry.URL', 'Homepage' ) ),
			new DropdownField( 'IsSpam', _t( 'GuestbookEntry.ISSPAM', 'Is Spam?' ), array( 0 => 'no', 1 => 'yes' ) ),
			new DropdownField( 'IsActive', _t( 'GuestbookEntry.ISACTIVE', 'Is activated?' ), array( 1 => 'yes', 0 => 'no' ) )
		);

		return $fields;
	}

	/**
	 * hooks writing the dataset and inserts the member ID
	 * @return void
	 */
	public function onBeforeWrite()
	{

		$currentMember = Member::currentMember();
		if( true == $currentMember )
		{
			$this->AuthorID = $currentMember->ID;
		}
		
		if( !$this->getField( 'ID' ) )
        {
            $this->new = true;
        }
		
		
		// XSS & SQLi prevention
		$this->Comment = convert::html2raw( $this->Comment, true, 60 );

		parent::onBeforeWrite();
	}

	/**
	 * after writing the entry, send an email to a pre-configured mailadress
	 * if address is given
	 * @return void
	 */
	public function onAfterWrite()
	{
		if( isset( $this->Guestbook()->ReceiverMailAddress )
			&& isset( $this->Guestbook()->ReceiverMailAddress )
			   && $this->Guestbook()->ReceiverMailAddress != ''
				   && $this->Guestbook()->ReceiverMailAddress != ''
					   && $this->new
			)
		{
			$strFrom	= $this->Guestbook()->ReceiverMailAddress;
			$strTo		= $this->Guestbook()->ReceiverMailAddress;
			$strSubject	= _t( 'GuestbookEntry.MAILSUBJECT', 'New guestbook entry :-)' );
			$strBody	= sprintf( _t(	'GuestbookEntry.MAILBODY',
				'You received a new guestbook entry on %s!' ),
				Director::absoluteBaseURL() );
			$strBody	.= "\n";
			$strBody	.= sprintf( _t( 'GuestbookEntry.MAILBODYNAME',
				'Name: %s %s' ), $this->getField( 'FirstName' ),
				$this->getField( 'LastName' ) );
            $strBody	.= "\n";
            $strBody	.= sprintf( _t( 'GuestbookEntry.MAILBODYTEXT', 'Text: %s' ),
				$this->getField( 'Comment' ) );
            $strBody	.= "\n";
            $strBody	.= sprintf( _t( 'GuestbookEntry.MAILBODYLINK', 'Link: %s' ),
				Director::absoluteURL( $this->Link() ) );

			$objEmail	= new Email( $strFrom, $strTo, $strSubject, $strBody );
			$objEmail->sendPlain();

		}

		parent::onAfterWrite();
	}

	/**
	 * generate a list of all entries with optional comments enritchment
	 * @param array $arrParam
	 * @return ObjectDataSet
	 */
	function getEntryList( $arrParam )
	{
		if( is_array( $arrParam ) )
		{
			$retVal = array();

			$limit = 0;
			if( true == array_key_exists( 'limit_start', $arrParam )
				&& '' != $arrParam[ 'limit_start' ] )
			{
				$limit = $arrParam[ 'limit_start' ] . ',' . $arrParam[ 'limit_end' ];
			}

			$sqlQuery = new SQLQuery();
			$sqlQuery->select = array( '*' );
			$sqlQuery->from = array( 'GuestbookEntry' );
			$sqlQuery->where = array( $arrParam[ 'filter' ] );
			$sqlQuery->orderby = $arrParam[ 'sort' ];

			/**
			 * get all entries, add comments if available & enabled,
			 * work on values like link protection and smilies
			 */
			$objEntryComments	= singleton( 'GuestbookEntryComment' );
			$arrEntries			= $sqlQuery->execute();

			foreach ( $arrEntries as $entry )
			{
				if( true == $arrParam[ 'comments' ] )
				{
					$objComments = $objEntryComments->getCommentsByEntryID( $entry[ 'ID' ], $arrParam[ 'sort' ] );
					if( is_object( $objComments ) )
					{
						$entry[ 'EntryCommentList' ] = $objComments;
					}
					else
					{
						/**
						 * workaround for ss 2.4x where the isValue()
						 * doesn't work with nested controls/DataObjectSets
						 */
						$entry[ 'EntryCommentList' ] = false;
					}
				}

				if( true == $arrParam[ 'cryptmail' ] )
				{
					$entry[ 'MailLink' ] = $entry[ 'MailLink' ] = Guestbook::getEmailLink( $entry );
				}

				if( true == $arrParam[ 'emoticons' ] )
				{
					#BBCodeParser::enable_smilies();
					$entry[ 'Comment' ] = Guestbook::getReplaceEmoticons( $entry[ 'Comment' ] );
				}

				$retVal[] = $entry;
			}

			$objDataObjectSet = $this->buildDataObjectSet( $retVal );

			if( true == array_key_exists( 'limit_end', $arrParam )
				&& is_numeric( $arrParam[ 'limit_end' ] )
				&& is_object( $objDataObjectSet )
				)
			{
				/**
				 * reverse-engineered pagination behaviour
				 */
				$intCount = $objDataObjectSet->TotalItems();

				$objDataObjectSet->setPageLimits(
						$arrParam[ 'limit_start' ],
						$arrParam[ 'limit_end' ],
						$intCount
				);

				$objSet = $objDataObjectSet->getRange(
						$arrParam[ 'limit_start' ],
						$arrParam[ 'limit_end' ]
				);

				$objSet->setPageLimits(
						$arrParam[ 'limit_start' ],
						$arrParam[ 'limit_end' ],
						$intCount
				);
			}
			else
			{
				$objSet = &$objDataObjectSet;
			}

			return $objSet;
		}
	}

	/**
	 * generates a link to a specific entry
	 * @return string link
	 */
	public function Link()
	{
		return $this->Guestbook()->Link() . "#" . _t( 'GuestbookEntry.LINKTEXT', 'Entry' ) . $this->ID;
	}

    /**
     * generates the id of this entry, used in templates
     * @return string
     */
    public function LinkId()
    {
        return _t('GuestbookEntry.LINKTEXT', 'Entry') . $this->ID;
    }

	/*
	 * rights management
	 *
	 **********************************************************/

	/**
	 * visible for every logged in user
	 * @param obj member
	 * @return bool
	 */
	public function canView( $member = null )
	{
		return true;
	}

	/**
	 * createable by every logged in user
	 * @param obj member
	 * @return bool
	 */
	public function canCreate( $member = null )
	{
		return true;
	}

	/**
	 * only users with matching IDs or flagged as ADMIN are allowed to edit
	 * @param obj member
	 * @return bool
	 */
	public function canEdit( $member = null )
	{
		$retVal = false;

		if( null !== $member )
		{
			$member = Member::currentUser();
			if( Permission::checkMember( $member, 'ADMIN' )
				|| ( $member
					&& $member->ID == $this->AuthorID ) )
			{
				$retVal = true;
			}
		}

		return $retVal;
	}

	/**
	 * wraps the canEdit() method for permission check
	 * @see canEdit()
	 * @param obj member
	 * @return bool
	 */
	public function canDelete( $member = null )
	{
		return $this->canEdit( $member );
	}
	
    /**
     * Checks, if the current user has the permission $perm, used in templates
     * @param string $perm
     * @return bool
     */
    public function checkPermission( $perm )
    {
        if( Permission::check( $perm ) != false )
        {
            return true;
        }
        return false;
    }

}
?>