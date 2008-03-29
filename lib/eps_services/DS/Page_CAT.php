<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . "DS" . DIR_SEP . "DSPage.php");
class Page extends DSPage {
  var $cid;
  var $images;
  var $cat;
  function Page(&$res) {
    global $_REQUEST;
    parent::DSPage($res);
    $this->cid = $_REQUEST["c"];
    $this->_cacheKey[] = $this->cid;
  }
  function setup(&$cached) {
    if (!$cached) {
      $this->cat = $this->conf["category_$this->cid"]["caption"];
      $this->files = explode(" ", $this->conf["category_$this->cid"]["files"]);
      foreach ($this->files as $id) {
        $def["caption"] = $this->conf["file_$id"]["caption"];
        $def["url"] = "#download#?n=$id&amp;c=".$this->dir;
        $this->register_link("_DS$id", new TLink($def));
      }
      $def["caption"]="Download";
      $def["url"] = "#service#?s=DS&amp;d=".$this->dir;
      $def["icon"] = "system_pin";
      $this->register_link("_DSHome", new TLink($def));
    }
  }
  function getTemplate() {
    return "category";
  }
  function getFooterLinks() {
    return array (
      "_DSHome"
    );
  }
}
?>
