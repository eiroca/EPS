{include file="header.tpl" pt="hp"}
  <p>Benvenuti sul sito di <b><span class="COL1">e</span><span class="COL2">I</span><span class="COL1">r</span><span class="COL2">O</span><span class="COL1">c</span><span class="COL2">A</span></b>, il sito per i pigri.</p>
  <div>{foreach from=$page->menu item=cat}{if $cat=="-"}</div>{hr width="25"}<div>{else}{link ref="$cat"}{/if}{/foreach}</div>
  <p>{$page->afo_des}</p>
  <p class="RIGHT">{if $page->afo_aut}<i>({$page->afo_aut})</i>{else}<i>(Anonimo)</i>{/if}{link ref="HP_AFO_HP"}</p>
{include file="footer.tpl" pt="hp"}