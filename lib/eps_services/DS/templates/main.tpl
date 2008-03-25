{include file="header.tpl" pt="sv"}
  <p>Download Server</p>
  <p>
    Categorie disponibili:{br}
    {foreach from=$page->cat key=id item=it}{link ref="_DS$id" newLine=TRUE}{/foreach}
  </p>
{include file="footer.tpl" pt="sv"}