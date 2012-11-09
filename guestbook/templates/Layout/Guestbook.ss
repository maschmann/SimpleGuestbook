<!--[if lt IE 9]>
<script>
    // html5shiv MIT @rem remysharp.com/html5-enabling-script
    // iepp v1.5.1 MIT @jon_neal iecss.com/print-protector
    /*@cc_on(function(p,e){var q=e.createElement("div");q.innerHTML="<z>i</z>";q.childNodes.length!==1&&function(){function r(a,b){if(g[a])g[a].styleSheet.cssText+=b;else{var c=s[l],d=e[j]("style");d.media=a;c.insertBefore(d,c[l]);g[a]=d;r(a,b)}}function t(a,b){for(var c=new RegExp("\\b("+m+")\\b(?!.*[;}])","gi"),d=function(k){return".iepp_"+k},h=-1;++h<a.length;){b=a[h].media||b;t(a[h].imports,b);r(b,a[h].cssText.replace(c,d))}}for(var s=e.documentElement,i=e.createDocumentFragment(),g={},m="abbr article aside audio canvas details figcaption figure footer header hgroup mark meter nav output progress section summary time video".replace(/ /g, '|'),
     n=m.split("|"),f=[],o=-1,l="firstChild",j="createElement";++o<n.length;){e[j](n[o]);i[j](n[o])}i=i.appendChild(e[j]("div"));p.attachEvent("onbeforeprint",function(){for(var a,b=e.getElementsByTagName("*"),c,d,h=new RegExp("^"+m+"$","i"),k=-1;++k<b.length;)if((a=b[k])&&(d=a.nodeName.match(h))){c=new RegExp("^\\s*<"+d+"(.*)\\/"+d+">\\s*$","i");i.innerHTML=a.outerHTML.replace(/\r|\n/g," ").replace(c,a.currentStyle.display=="block"?"<div$1/div>":"<span$1/span>");c=i.childNodes[0];c.className+=" iepp_"+
     d;c=f[f.length]=[a,c];a.parentNode.replaceChild(c[1],c[0])}t(e.styleSheets,"all")});p.attachEvent("onafterprint",function(){for(var a=-1,b;++a<f.length;)f[a][1].parentNode.replaceChild(f[a][0],f[a][1]);for(b in g)s[l].removeChild(g[b]);g={};f=[]})}()})(this,document);@*/
</script>
<![endif]-->
<section id="guestbook">
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
</section>