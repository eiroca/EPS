{include file="header.tpl" pt="pg"}
  <p>Invia il tuo suggerimento a eIrOcA.{br}
    Inserisci il tuo nome (opzionale):{br}
    <input name="from" size="40" />{br}
    Commento/Suggerimento:{br}
    <input name="sugg" size="200" />{br}
    <a href="service.php?s=EIROCA&amp;a=SUG&amp;from=$from&amp;sugg=$sugg">Invia</a>
  </p>
{include file="footer.tpl" pt="pg"}