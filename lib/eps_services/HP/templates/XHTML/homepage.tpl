{include file="header.tpl" pt="hp"}
  {if $page->message}<p>{$page->message}</p>{/if}
  <div>{foreach from=$page->menu item=cat}{if $cat=="-"}</div>{hr width="25"}<div>{else}{link ref="$cat"}{/if}{/foreach}</div>
  <p>{$page->afo_des}</p>
  <p class="RIGHT">{if $page->afo_aut}<i>({$page->afo_aut})</i>{else}<i>(Anonimo)</i>{/if}{link ref="HP_AFO_HP"}</p>
{include file="footer.tpl" pt="hp"}