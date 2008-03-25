{include file="header.tpl" pt="pg"}
  <p>
    <b>{$page->det.title}</b>{br}
    {$page->det.description}{br}
    {foreach from=$page->links item=link}{link ref="$link"}{/foreach}
  </p>
{include file="footer.tpl" pt="pg"}