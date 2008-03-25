{include file="header.tpl" pt="hp"}
  <p>Benvenuti sul sito di <b>eIrOcA</b>, il sito per i pigri.{br}&nbsp;{br}
    {foreach from=$page->menu item=cat}{if $cat=="-"}{else}{link ref="$cat"}{/if}{/foreach}
  </p>
  <p>------{br}{$page->afo_des}</p>
{include file="footer.tpl" pt="hp"}