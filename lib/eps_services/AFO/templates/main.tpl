{include file="header.tpl" pt="sv"}
  <p>
    {$page->caption}{br}&nbsp;{br}
    {foreach from=$page->categories item=id}{link ref="AFO_cat_$id"}{/foreach}
  </p>
{include file="footer.tpl" pt="sv"}