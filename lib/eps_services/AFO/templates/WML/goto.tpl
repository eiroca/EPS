{include file="header.tpl" pt="pg"}
  <p>
    {$page->description}{br}
    Sono disponibili {$page->count} aforismi.{br}
    Vai al numero <input name="i" size="4"/>{br}
    <a href="service.php?s=AFO&amp;a=SHOW&amp;cat={$page->cid}&amp;i=$i">Vai</a>
  </p>
{include file="footer.tpl" pt="pg"}