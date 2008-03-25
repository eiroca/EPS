{include file="header.tpl" pt="ch"}
  {if $page->message}<p>{$page->message}</p>{/if}
  <p>{if $page->description}{$page->description}{br}&nbsp;{br}{/if}
    {foreach from=$page->menu item=item}{if $item=="-"}{hr width="25%"}{else}{link ref="$item"}{/if}{/foreach}
    {link ref="back"}
</p>
{include file="footer.tpl" pt="ch"}