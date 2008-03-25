{include file="header.tpl" pt="ch"}
  <p>{$page->description}{br}
    &nbsp;{br}
    {foreach from=$page->menu item=item}{if $item=="-"}{hr width="25%"}{else}{link ref="$item"}{/if}{/foreach}
    {link ref="back"}
</p>
{include file="footer.tpl" pt="ch"}