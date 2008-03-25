{include file="header.tpl" pt="pg"}
  <p>{$page->cat}{br}
    &nbsp;{br}
    {foreach from=$page->files item=id}{link ref="_DS$id"}{/foreach}
  </p>
{include file="footer.tpl" pt="pg"}