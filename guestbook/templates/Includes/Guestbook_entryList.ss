		<% control EntryList %>
			<li class="$EvenOdd $FirstLast">
				<% if Title %><h3><a href="$Link" title="$Title.XML" id="$LinkId">$Title.XML</a></h3><% end_if %>
				<p>$Comment</p>
				<p class="smallText name">
				<% if Top.EncryptEmail %>
					<% _t('Guestbook.ss.FROM', 'from') %> $MailLink
					<% if Url %>&nbsp;<a href="$Url.XML" class="homepageLink" title="<% _t('Guestbook.ss.HOMEPAGE', 'website') %>">(<% _t('Guestbook.ss.HOMEPAGE', 'website') %>)</a><% end_if %>
					/ $Created.format( Y-m-d H:m )
				<% else %>
					<% _t('Guestbook.ss.FROM', 'from') %> $FirstName.XML
					<% if LastName %><% if Top.ShowLastNameInEntries %> $LastName.XML<% end_if %><% end_if %>
					<% if Url %>&nbsp;<a href="$Url.XML" class="homepageLink" title="<% _t('Guestbook.ss.HOMEPAGE', 'website') %>">(<% _t('Guestbook.ss.HOMEPAGE', 'website') %>)</a><% end_if %>
					/ $Created.format( Y-m-d H:m )
				<% end_if %>
				</p>
				<% if Top.CurrentUser %>
				<p class="smallText entryTools">
					<% if checkPermission(GUESTBOOK_CHANGECOMMENTSTATE) %>
					    <a class="spam" href="{$Top.Link}doAction/$ID?do=spam" title="<% _t('Guestbook.ss.ENTRYISSPAM', 'entry is spam') %>">&nbsp;</a>
                    <% end_if %>
					<% if checkPermission(GUESTBOOK_DELETEENTRY) %>
					    <a class="delete" href="{$Top.Link}doAction/$ID?do=deleteEntry" title="<% _t('Guestbook.ss.DELENTRY', 'delete entry') %>">&nbsp;</a>
					<% end_if %>
					<% if Top.EntryComments %>
                        <% if checkPermission(GUESTBOOK_ADDCOMMENT) %>
					        <a href="{$Top.Link}doAction/$ID?do=addComment" class="comment popForm" title="<% _t('Guestbook.ss.NEWCOMMENT', 'add comment') %>">&nbsp;</a>
                        <% end_if %>
					<% end_if %>
				</p>
				<% end_if %>
				<% include Guestbook_entryCommentsList %>
				<br class="clear" />
			</li>
		<% end_control %>