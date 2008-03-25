{include file="header.tpl" pt="pg"}
  <p>{$page->cat}{br}
    &nbsp;{br}
    {foreach from=$page->images item=id}{link ref="_PG$id"}{/foreach}
  </p>
{include file="footer.tpl" pt="pg"}