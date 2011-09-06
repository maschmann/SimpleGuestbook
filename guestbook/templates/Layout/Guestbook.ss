<!--[if IE 6 ]><div id="guestbook" class="ie6"><![endif]-->
<!--[if IE 7 ]><div id="guestbook" class="ie7"><![endif]-->
<!--[if IE 8 ]><div id="guestbook" class="ie8"><![endif]-->
<!--[if (gt IE 8)]><div id="guestbook" class="ie"><![endif]-->
<!--[if !IE]><!--><div id="guestbook" class="noie"><!--<![endif]-->
	$SpamProtectionOptions
	<h2>$Title</h2>
	$Content
	$Form
	<a href="{$Link}doAction?do=showSmilies" title="<% _t('Guestbook.ss.SHOWSMILIESCODE', 'emoticon map') %>" class="popForm">
		<% _t('Guestbook.ss.SHOWSMILIESCODE', 'emoticon map') %>
	</a>
	<span id="FormMessage"><!-- shows form messages/errors --></span>
	<% if EntryList %>
		<ol id="entryList">
		<% include Guestbook_entryList %>
		</ol>
		<div id="popForm"><!-- empty layer for comments --></div>
	<% else %>
	<h3><% _t('Guestbook.ss.NOENTRIESYET', 'no entries yet') %></h3>
	<% end_if %>
	<% if ShowPagination %>
	<% if EntryList.MoreThanOnePage %>
		<% include Guestbook_pagination %>
	<% end_if %>
	<% end_if %>
</div>