		<div id="PageNumbers">
			<p>
				<% if EntryList.NotFirstPage %>
					<a class="prev" href="$EntryList.PrevLink" title="<% _t('Guestbook.ss.PREVIOUSPAGE', 'view the previous page') %>">&laquo; <% _t('Guestbook.ss.PREVIOUS', 'prev') %></a>
				<% end_if %>
				<span>
					<% control EntryList.PaginationSummary(4) %>
					<% if CurrentBool %>
						$PageNum
					<% else %>
						<% if Link %>
							<a href="$Link" title="<% _t('Guestbook.ss.VIEWPAGENO', 'view page number') %> $PageNum">$PageNum</a>
						<% else %>
							&hellip;
						<% end_if %>
					<% end_if %>
					<% end_control %>
				</span>
				<% if EntryList.NotLastPage %>
					<a class="next" href="$EntryList.NextLink" title="<% _t('Guestbook.ss.NEXTPAGE', 'view the next page') %>"><% _t('Guestbook.ss.NEXT', 'next') %> &raquo;</a>
				<% end_if %>
			</p>
		</div>