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

  var $info;

  function Page(&$res) {
    parent::RSSPage($res);
    $this->nid = $this->getRequestVar('i');
    $this->_cacheKey[] = $this->nid;
  }

  function setup(&$cached) {
    if (!$cached) {
      parent::setup($cached);
      $this->info = $this->rss->items[$this->nid];
      $this->_objects['info'] = 'info';
      $def = [ ];
      $def['caption'] = $this->rss->channel['title'];
      $def['url'] = '#service#?s=RSS&amp;r=' . $this->rid;
      $link = new TLink($def);
      $this->register_link('rss_home', $link);
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
      unset($def);
      if ($this->getConf('type', '0') === '1') {
        $def['caption'] = 'qui';
        $def['url'] = $this->info['pod_url'];
        $link = new TLink($def);
        $this->register_link('rss_link', $link);
        if ($this->nid > 0) {
          $def['caption'] = 'podcast precedente';
          $def['url'] = '#service#?s=RSS&amp;a=SHOW&amp;r=' . $this->rid . '&amp;i=' . ($this->nid - 1);
          $link = new TLink($def);
          $this->register_link('rss_prev', $link);
        }
        if ($this->nid < count($this->rss->items) - 1) {
          $def['caption'] = 'podcast successiva';
          $def['url'] = '#service#?s=RSS&amp;a=SHOW&amp;r=' . $this->rid . '&amp;i=' . ($this->nid + 1);
          $link = new TLink($def);
          $this->register_link('rss_next', $link);
        }
      }
      else {
        $def['caption'] = 'qui';
        $def['url'] = $this->info['link'];
        $link = new TLink($def);
        $this->register_link('rss_link', $link);
        if ($this->nid > 0) {
          $def['caption'] = 'notizia precedente';
          $def['url'] = '#service#?s=RSS&amp;a=SHOW&amp;r=' . $this->rid . '&amp;i=' . ($this->nid - 1);
          $link = new TLink($def);
          $this->register_link('rss_prev', $link);
        }
        if ($this->nid < count($this->rss->items) - 1) {
          $def['caption'] = 'notizia successiva';
          $def['url'] = '#service#?s=RSS&amp;a=SHOW&amp;r=' . $this->rid . '&amp;i=' . ($this->nid + 1);
          $link = new TLink($def);
          $this->register_link('rss_next', $link);
        }
      }
    }
  }

  function getTemplate() {
    return 'show';
  }

  function getFooterLinks() {
    return array (
        'back' => 'rss_home'
    );
  }

}
?>