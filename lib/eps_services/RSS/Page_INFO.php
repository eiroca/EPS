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

  var $nid;

  var $det;

  function Page(&$res) {
    parent::RSSPage($res);
    $this->nid = 'news_' . $this->getRequestVar('i', '');
    $this->_cacheKey[] = $this->nid;
  }

  function setup(&$cached) {
    if (!$cached) {
      parent::setup($cached);
      $def = [ ];
      $def['caption'] = $this->rss->channel['title'];
      $def['url'] = '#service#?s=RSS&amp;r=' . $this->rid;
      $link = new TLink($def);
      $this->register_link('rss_home');
      unset($def);
      $def['caption'] = 'qui';
      $def['url'] = $this->rss->channel['link'];
      $link = new TLink($def);
      $this->register_link('rss_link', $link);
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
    }
  }

  function getTemplate() {
    return 'info';
  }

  function getFooterLinks() {
    return array (
        'back' => 'rss_home'
    );
  }

}
?>