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
    public static $singular_name = 'GuestbookEntryComment';

    /**
     * name of the object in singular
     *
     * @var string
     */
    public static $plural_name = 'GuestbookEntryComments';

    /**
     * database column definitions
     * @var array
     */
    public static $db = array(
        'Title'   => 'Varchar(255)',
        // title for the entry
        'Comment' => 'HTMLText',
        // the actual entry
    );

    /**
     * attribute relations
     * @var array
     */
    public static $has_one = array(
        'GuestbookEntry' => 'GuestbookEntry',
        'Author'         => 'Member',
    );

    /**
     * fields for model admin search results
     * @var array
     */
    public static $summary_fields = array(
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
        $fields = new FieldList(
            new TextField( 'Title', _t( 'GuestbookEntry.TITLE', 'Title' ) ),
            new TextareaField( 'Comment', _t( 'GuestbookEntry.COMMENT', 'Comment' ) ),
            new HiddenField( 'EntryID', '', Controller::curr()->urlParams[ 'ID' ] )
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

        $currentUserId = Member::currentUserID();
        if( 0 < $currentUserId ) {
            $this->AuthorID = $currentUserId;
        }

        parent::onBeforeWrite();
    }


    /**
     * gets all comments for an entry
     *
     * @param integer $intEntryId
     * @param string $orderBy
     * @return DataObjectSet
     */
    public function getCommentsByEntryID( $intEntryId, $orderBy = 'Created DESC' )
    {
        if( is_numeric( $intEntryId ) ) {
        /*    $sqlQuery         = new SQLQuery();
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
            $sqlQuery->from   = array(
                'GuestbookEntryComment GC',
                'LEFT JOIN ( Member M )',
                'ON ( M.ID = GC.AuthorID )',
            );
            $sqlQuery->where  = array(
                'GC.GuestbookEntryID = ' . (int)$intEntryId,
            );
            $sqlQuery->orderby( $orderBy );

            return $this->buildDataObjectSet( $sqlQuery->execute() );*/

        }
    }


    /**
     * deletes all comments for an entry
     *
     * @param integer $intEntryId
     * @return void
     */
    public function deleteCommentsByEntryID( $intEntryId )
    {
        if( is_numeric( $intEntryId ) ) {
            $sqlQuery         = new SQLQuery();
            $sqlQuery->delete = true;
            $sqlQuery->from   = array( 'GuestbookEntryComment' );
            $sqlQuery->where  = array( 'GuestbookEntryID=' . (int)$intEntryId );
            $sqlQuery->execute();
        }
    }


    /**
     * Checks, if the current user has the permission $perm, used in templates
     * @param string $perm
     * @return bool
     */
    public function checkPermission( $perm )
    {
        if( Permission::check( $perm ) != false ) {
            return true;
        }

        return false;
    }

}