{include file="header.tpl" pt="sv"}
{if $rss}
<p>
  Canale: {link ref="rss_info"}{br}
  {foreach from=$page->news item=item}{link ref="$item"}{/foreach}
</p>
{else}
<p>Impossibile reperire le notizie {if $page->conf.caption}del canale &quot;{$page->conf.caption}&quot;{/if}.</p>
{/if}
{include file="footer.tpl" pt="sv"}