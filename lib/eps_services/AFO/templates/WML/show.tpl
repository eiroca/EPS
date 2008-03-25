{include file="header.tpl" pt="pg"}
  <p align="center"><b>{$page->caption}</b>{br}</p>
  <p>{$page->aforisma.description}</p>
  {if ($page->kind_id == 1) || ($page->aforisma.author)}<p align="right">{if $page->aforisma.author}<i>({$page->aforisma.author})</i>{else}<i>(Anonimo)</i>{/if}</p>{/if}
  {if $page->aforisma.traduzione}<p><i>{$page->aforisma.traduzione}</i></p>{/if}
  {if $page->aforisma.note}<p>Note: <small>{$page->aforisma.note}</small></p>{/if}
  {if $page->aforisma.significato}<p>Significato: <small>{$page->aforisma.significato}</small></p>{/if}
  {if $page->aforisma.commento}<p>Commento: <small>{$page->aforisma.commento}</small></p>{/if}
  <p>
    {link ref="AFO_next"}
    {link ref="AFO_random"}
  </p>
{include file="footer.tpl" pt="pg"}