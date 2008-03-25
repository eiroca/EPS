{include file="header.tpl" pt="pg"}
  <p>{link ref="PG_prev"}</p>
  <p align="center">
    --- {$page->i_pos}/{$page->i_count} ---{br}
    {icon ref="IMG"}{br}
    <b>{$page->img_caption}</b>{br}
    {if $page->img_copyright}<small>{$page->img_copyright}</small>{/if}
  </p>
  <p>{link ref="PG_next"}</p>
{include file="footer.tpl" pt="pg"}