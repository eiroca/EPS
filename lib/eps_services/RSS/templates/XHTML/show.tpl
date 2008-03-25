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
    {if $page->conf.type eq 1}
      {filter handset="object_download_ringtone_mp3 1"}
        File di tipo: {$info.pod_type}{br}
        File di dimensione: {$info.pod_length}{br}{br}
        Per scaricare il file clicka {link ref="rss_link"}
      {/filter}
      {filter handset="object_download_ringtone_mp3 0"}
        Il tuo dispositivo non supporta il formato del file.
      {/filter}
    {else}
      Per andare a leggere la notizia clicka {link ref="rss_link"}
    {/if}
    {br}
    {link ref="rss_next"} {link ref="rss_prev"}
  </p>
{include file="footer.tpl" pt="pg"}