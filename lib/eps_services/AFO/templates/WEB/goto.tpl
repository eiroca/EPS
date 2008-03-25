{include file="header.tpl" pt="pg"}
  <form action="web.php">
     <p>
      {$page->description}{br}
      Sono disponibili {$page->count} aforismi.{br}
      Vai al numero
      <input type="hidden" name="s" value="AFO"/>
      <input type="hidden" name="a" value="SHOW"/>
      <input type="hidden" name="c" value="{$page->cid}"/>
      <input type="text" name="i" value="1" size="4" />{br}
      <input type="submit" value="Vai" name="btn"/>
    </p>
  </form>
{include file="footer.tpl" pt="pg"}