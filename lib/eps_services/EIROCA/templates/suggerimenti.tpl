{include file="header.tpl" pt="pg"}
  <p>
    {if $page->result eq 2}Il tuo suggerimento e' stato correttamente ricevuto. Grazie della tua collaborazione.{/if}
    {if $page->result eq 1}Anche se non hai inviato un suggerimento, grazie della tua collaborazione.{/if}
    {if $page->result eq 0}Siamo spiacenti ma e' stato impossibile archiviare il tuo suggerimento, riprova un'altro giorno.{/if}
    {br}
    {link ref="EIROCA_back"}
  </p>
{include file="footer.tpl" pt="pg"}