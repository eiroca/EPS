<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2019 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.3
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . 'DS' . DIR_SEP . 'DSPage.php');

class Page extends DSPage {

  var $cid;

  var $images;

  var $cat;

  function Page(&$res) {
    parent::DSPage($res);
    $this->cid = $this->getRequestVar('c');
    $this->_cacheKey[] = $this->cid;
  }

  function setup(&$cached) {
    if (!$cached) {
      $this->cat = $this->conf['category_' . $this->cid]['caption'];
      $files = explode(' ', $this->conf['category_' . $this->cid]['files']);
      $this->files = $files;
      $def = [ ];
      foreach ($this->files as $id) {
        $def['caption'] = $this->conf['file_' . $id]['caption'];
        $def['url'] = '#download#?n=' . $id . '&amp;c=' . $this->dir;
        $link = new TLink($def);
        $this->register_link('_DS' . $id, $link);
      }
      $def['caption'] = 'Download';
      $def['url'] = '#service#?s=DS&amp;d=' . $this->dir;
      $def['icon'] = 'system_pin';
      $link = new TLink($def);
      $this->register_link('_DSHome', $link);
    }
  }

  function getTemplate() {
    return 'category';
  }

  function getFooterLinks() {
    return array (
        '_DSHome'
    );
  }

}
?>
