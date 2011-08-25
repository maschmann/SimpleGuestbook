<% if EntryCommentList %>
<h4><% _t('Guestbook.ss.COMMENTSTITLE', 'comments:') %></h4>
<ol>
	<% control EntryCommentList %>
	<li class="$EvenOdd $FirstLast">
		<h5>$Title.XML</h5>
		<p>$Comment.XML</p>
		<p class="smallText name"><% _t('Guestbook.ss.FROM', 'from') %> $FirstName.XML<% if Top.ShowLastNameInEntries %> $Surname.XML<% end_if %> / $Created.format( Y-m-d H:m )</p>
		<% if Top.CurrentUser %>
		<p class="smallText entryTools">
			<% if Top.isAdmin %>
			<a class="delete" href="{$Top.Link}doAction/$ID?do=deleteComment" title="<% _t('Guestbook.ss.DELCOMMENT', 'delete comment') %>">&nbsp;</a>
			<% end_if %>
		</p>
		<br class="clear" />
		<% end_if %>
	</li>
	<% end_control %>
</ol>
<% end_if %>