<% if CurrentUser %>
$commentForm
<script type="text/javascript">
/* <![CDATA[ */
	initForm( 'CommentForm', {$EntryID} );
/* ]]> */
</script>
<% else %>
<h3><% _t('Guestbook_addComment.ss.NOTLOGGEDIN','You\'re not logged in, please authenticate!') %></h3>
<% end_if %>