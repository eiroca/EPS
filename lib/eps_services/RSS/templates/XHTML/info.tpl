{include file="header.tpl" pt="pg"}
  {if $rss->image.url}<div class="CENTER">{icon ref="rss_icon"}</div>{/if}
  <p>
    <b>{$rss->channel.title}</b>{if $rss->channel.dc.subject} ({$rss->channel.dc.subject}){/if}{br}
    {$rss->channel.description}.{br}
    {br}
    <small>{if $rss->channel.dc.rights}{$rss->channel.dc.rights}{br}{/if}</small>
    Per andare su {$rss->channel.title} clicca {link ref="rss_link"}
  </p>
{include file="footer.tpl" pt="pg"}