<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2019 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.3
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . 'PG' . DIR_SEP . 'PGPage.php');

class Page extends PGPage {

  var $cid;

  var $iid;

  var $caption;

  var $cat;

  var $images;

  var $i_pos;

  var $i_count;

  function Page(&$res) {
    parent::PGPage($res);
    $this->cid = $this->getRequestVar('c');
    $this->_cacheKey[] = $this->cid;
    $this->iid = $this->getRequestVar('i');
    $this->_cacheKey[] = $this->iid;
  }

  function setup(&$cached) {
    if (!$cached) {
      global $HANDSET;
      $this->images = explode(' ', $this->conf['category_' . $this->cid]['files']);
      $this->cat = $this->conf['category_' . $this->cid]['caption'];
      foreach ($this->conf['file_' . $this->iid] as $nam => $val) {
        $name = 'img_' . $nam;
        $this->$name = $val;
      }
      $this->i_pos = array_search($this->iid, $this->images) + 1;
      $this->i_count = count($this->images);
      $prv = $this->i_pos - 2;
      $nxt = $this->i_pos;
      if ($prv < 0) {
        $prv = $this->i_count - 1;
      }
      if ($nxt >= $this->i_count) {
        $nxt = 0;
      }
      $def = [ ];
      $def['caption'] = '&gt;&gt;';
      $def['style'] = 1;
      $def['url'] = '#service#?s=PG&amp;a=IMG&amp;c=' . $this->cid . '&amp;i=' . $this->images[$nxt];
      $link = new TLink($def);
      $this->register_link('PG_next', $link);
      $def['caption'] = '&lt;&lt;';
      $def['url'] = '#service#?s=PG&amp;a=IMG&amp;c=' . $this->cid . '&amp;i=' . $this->images[$prv];
      $link = new TLink($def);
      $this->register_link('PG_prev', $link);
      $def['caption'] = 'elenco';
      $def['url'] = '#service#?s=PG&amp;a=CAT&amp;c=' . $this->cid;
      $def['icon'] = 'system_dot3';
      unset($def['style']);
      $link = new TLink($def);
      $this->register_link('PG_elenco', $link);
      unset($def);
      $file = $this->conf['file_' . $this->iid]['path'] . $this->conf['file_' . $this->iid]['file'];
      $w = $HANDSET->display_max_image_width;
      if ($w == NULL) {
        $w = $HANDSET->display_resolution_width;
      }
      if ($w > 352) {
        $w = 352;
      }
      $def['alt_text'] = $this->img_caption;
      $def['width'] = $w;
      $def['url'] = $file;
      $def['rescale'] = true;
      // $def['prefix'] = 'prefix_id';
      // $def['hidename'] = true;
      $def['format'] = 'jpg';
      $def['mime_type'] = 'image/jpeg';
      $image = new TImage($def);
      $this->register_image('_IMG', $image);
      unset($def);
      $def['images'] = '_IMG';
      $def['alt_text'] = '[[immagine non disponibile]]';
      $icon = new TIcon($def);
      $this->register_icon('IMG', $icon);
    }
  }

  function getTemplate() {
    return 'picture';
  }

  function getFooterLinks() {
    return array (
        'PG_elenco', 'PG_home'
    );
  }

}
?>