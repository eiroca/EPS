{include file="header.tpl" pt="pg"}
  <p class="CENTER">
    <b>{$page->img_caption}</b>{br}
    {icon ref="IMG"}{br}
    {if $page->img_copyright}
      <small>{$page->img_copyright}</small>{br}
    {/if}
  </p>
  <p class="CENTER">
    {link ref="PG_prev"} {$page->i_pos}/{$page->i_count} {link ref="PG_next"}
  </p>
{include file="footer.tpl" pt="pg"}