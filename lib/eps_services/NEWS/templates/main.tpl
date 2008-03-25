{include file="header.tpl" pt="sv"}
  <p>
    <b>{$page->last.title}</b>{br}
    {$page->last.description}{br}
    &nbsp;{br}
    Altre notizie:{br}
    {foreach from=$page->news item=not}{link ref="NEWS_news_$not"}{/foreach}
  </p>
{include file="footer.tpl" pt="sv"}