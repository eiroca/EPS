{include file="header.tpl" pt="pg"}
  <p>
    <b>{$rss->channel.title}</b>{if $rss->channel.dc.subject} ({$rss->channel.dc.subject}){/if}{br}
    {$rss->channel.description}.{br}
    {br}
    <small>{if $rss->channel.dc.rights}{$rss->channel.dc.rights}{br}{/if}</small>
  </p>
{include file="footer.tpl" pt="pg"}