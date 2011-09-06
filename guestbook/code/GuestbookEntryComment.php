<?php
/**
 * GuestbookEntryComment
 *
 * @author Marc Aschmann <marc (at) aschmann.org>
 * @package guestbook
 */

class GuestbookEntryComment extends DataObject
{
	/**
	 * name of the object in singular
	 *
	 * @var string
	 */
	static $singular_name = 'GuestbookEntryComment';

	/**
	 * name of the object in singular
	 *
	 * @var string
	 */
	static $plural_name = 'GuestbookEntryComments';

	/**
	 * database column definitions
	 * @var array
	 */
	static $db = array(
		'Title'		=> 'Varchar(255)',	// title for the entry
		'Comment'	=> 'HTMLText',			// the actual entry
	);

	/**
	 * attribute relations
	 * @var array
	 */
	static $has_one = array(
		'GuestbookEntry'	=> 'GuestbookEntry',
		'Author'			=> 'Member',
	);

	/**
	 * fields for model admin search results
	 * @var array
	 */
	static $summary_fields = array(
		'Title',
		'Comment',
		'AuthorID',
	);

	/**
	 * definition of form fields
	 *
	 * @return obj FieldSet
	 */
	public function getCMSFields()
	{
		$fields = new FieldSet(
			new TextField( 'Title', _t( 'GuestbookEntry.TITLE', 'Title' ) ),
			new TextareaField( 'Comment', _t( 'GuestbookEntry.COMMENT', 'Comment' ) ),
#			new HiddenField( 'EntryID', '', Director::urlParam( 'ID' ) )
			new HiddenField( 'EntryID', '', Controller::curr()->urlParams['ID'] )
		);

		return $fields;
	}

	/**
	 * hooks writing the dataset and inserts the member ID
	 *
	 * @return void
	 */
	public function onBeforeWrite()
	{

		$currentMember = Member::currentMember();
		if( true == $currentMember )
		{
			$this->AuthorID = $currentMember->ID;
		}

		parent::onBeforeWrite();
	}

	/**
	 * gets all comments for an entry
	 *
	 * @param integer $intEntryID
	 * @return DataObjectSet
	 */
	public function getCommentsByEntryID( $intEntryID, $orderBy='Created DESC' )
	{
		if( is_numeric( $intEntryID ) )
		{
			$sqlQuery = new SQLQuery();
			$sqlQuery->select = array(
					'GC.ID',
					'GC.Created',
					'GC.Title',
					'GC.Comment',
					'M.FirstName',
					'M.Surname',
					'M.Email',
					'GC.ClassName AS ClassName',
					'GC.ClassName AS RecordClassName',
				);
			$sqlQuery->from = array(
					'GuestbookEntryComment GC',
					'LEFT JOIN ( Member M )',
					'ON ( M.ID = GC.AuthorID )',
				);
			$sqlQuery->where = array(
					'GC.GuestbookEntryID = ' . (int)$intEntryID,
				);
			$sqlQuery->orderby( $orderBy );

			return $this->buildDataObjectSet( $sqlQuery->execute() );
		}
	}

	/**
	 * deletes all comments for an entry
	 *
	 * @param integer $intEntryID
	 * @return void
	 */
	public function deleteCommentsByEntryID( $intEntryID )
	{
		if( is_numeric( $intEntryID ) )
		{
			$sqlQuery = new SQLQuery();
			$sqlQuery->delete = true;
			$sqlQuery->from = array( 'GuestbookEntryComment' );
			$sqlQuery->where = array( 'GuestbookEntryID=' . (int)$intEntryID );
			$sqlQuery->execute();
		}
	}

	/**
   * Checks, if the current user has the permission $perm, used in templates
   * @param string $perm
   * @return bool
   */
	public function checkPermission($perm)
	{
		if(Permission::check($perm) != false)
		{
			return true;
		}

		return false;
	}

}