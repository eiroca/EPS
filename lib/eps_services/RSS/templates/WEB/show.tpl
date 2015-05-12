{include file="header.tpl" pt="pg"}
  {if $rss->image.url}<div class="CENTER">{icon ref="rss_icon"}</div>{/if}
  <p>
    <b>{$info.title}</b>.{br}
    {if $info.description}{$info.description|strip_tags|escape}{br}{/if}
    {br}
    <small>
      {if $info.dc.date}del {$info.dc.date|rss_date_parse|date_format:"%d/%m/%Y "}{/if}
      {if $info.dc.creator}di {$info.dc.creator}{br}{/if}
      {if $info.slash.comments}commenti: {$info.slash.comments}{br}
      {/if}
    </small>
    Per andare a leggere la notizia clicca {link ref="rss_link"}
    {br}
    {link ref="rss_next"} {link ref="rss_prev"}
  </p>
{include file="footer.tpl" pt="pg"}