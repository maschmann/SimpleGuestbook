<% if smiliesMap %>
<ol>
    <lh><h2><% _t('Guestbook.ss.SHOWSMILIESCODE', 'emoticon map') %></h2></lh>
    <% control smiliesMap %>
    <li>$Img&nbsp;&nbsp;&raquo;&nbsp;&nbsp;$Code</li>
    <% end_control %>
</ol>
<% end_if %>