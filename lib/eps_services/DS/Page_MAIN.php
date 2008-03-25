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
  var $cat;
  function Page(&$res) {
    parent::DSPage($res);
  }
  function setup(&$cached) {
    if (!$cached) {
      $this->cat = explode(" ", $this->conf["main"]["categories"]);
      foreach ($this->cat as $id) {
        $def["caption"] = $this->conf["category_$id"]["caption"];
        $img = explode(" ", $this->conf["category_$id"]["files"]);
        $def["url"] = "#service#?s=DS&amp;a=CAT&amp;d=".$this->dir."&amp;c=$id";
        $this->register_link("_DS$id", new TLink($def));
      }
    }
  }
  function getTemplate() {
    return "main";
  }
}
?>
