{include file="header.tpl" pt="sv"}
  <p>Picture Gallery</p>
  <p>
    Gallerie disponibili:{br}
    {foreach from=$page->cat key=id item=gal}{link ref="_PG$id" newLine=TRUE}{/foreach}
{filter handset="image_format_jpg 0"}
    &nbsp;{br}
    Attenzione, siamo spiacenti ma le immagini presenti nelle varie gallerie non saranno visualizzabili dal tuo telefono.
{/filter}
  </p>
{include file="footer.tpl" pt="sv"}