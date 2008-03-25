{include file="header.tpl" pt="pg"}
  <form action="service.php">
    <p>Invia il tuo suggerimento a eIrOcA.{br}
      Inserisci il tuo nome (opzionale):
      <input type="hidden" name="s" value="EIROCA" size="0" />{br}
      <input type="hidden" name="a" value="SUG" size="0" />{br}
      <input type="text" name="from" value="anonimo" size="0" />{br}
      Commento/Suggerimento:{br}
      <textarea name="sugg" rows="0" cols="0"></textarea>{br}
      <input type="submit" value="Invia" name="Invia"/>{br}
    </p>
  </form>
{include file="footer.tpl" pt="pg"}