<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2019 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.3
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . 'RSS' . DIR_SEP . 'RSSPage.php');

class Page extends RSSPage {

  var $news;

  function Page(&$res) {
    parent::RSSPage($res);
  }

  function setup(&$cached) {
    if (!$cached) {
      parent::setup($cached);
      $def = [ ];
      $def['caption'] = @$this->rss->channel['title'];
      $def['url'] = '#service#?s=RSS&amp;a=INFO&amp;r=' . $this->rid;
      $link = new TLink($def);
      $this->register_link('rss_info', $link);
      unset($def);
      if (isset($this->rss->image['url'])) {
        $img = $this->rss->image['url'];
        $def['alt_text'] = ' ';
        $def['url'] = $img;
        $info = pathinfo($img);
        $def['format'] = $info['extension'];
        $image = new TImage($def);
        $this->register_image('_IMG', $image);
        unset($def);
      }
      $def['images'] = '_IMG';
      $def['alt_text'] = ' ';
      $icon = new TIcon($def);
      $this->register_icon('rss_icon', $icon);
      if ($this->rss) {
        foreach ($this->rss->items as $key => $item) {
          $this->news[$key] = 'rss_news' . $key;
          $def['caption'] = $item['title'];
          $def['url'] = '#service#?s=RSS&amp;a=SHOW&amp;r=' . $this->rid . '&amp;i=' . $key;
          $link = new TLink($def);
          $this->register_link($this->news[$key], $link);
        }
      }
    }
  }

  function getTemplate() {
    return 'main';
  }

}
?>