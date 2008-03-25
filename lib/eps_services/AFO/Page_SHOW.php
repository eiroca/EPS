<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . "AFO" . DIR_SEP . "AFOPage.php");
class Page extends AFOPage {
  var $iid;
  var $cid;
  var $caption;
  var $aforismo;
  var $afo;
  function Page(&$res) {
    parent::AFOPage($res);
    global $_REQUEST;
    $this->iid = $_REQUEST["i"];
    $this->cid = $_REQUEST["c"];
    if (!$this->iid) {
      $this->loadAfo();
      $count = (int) $this->afo["main"]["count"];
      $this->iid = rand(1, $count);
    }
    $this->_cacheKey[] = $this->cid;
    $this->_cacheKey[] = $this->iid;
  }
  function loadAfo() {
    global $CONFIG;
    global $SERVICE;
    if (!$this->afo) {
      $cat = "category_" . $this->cid;
      $path = $SERVICE->findData($this->conf[$cat]["path"]);
      $this->afo = parse_ini_file($path, true);
    }
  }
  function setup(&$cached) {
    if (!$cached) {
      $this->loadAfo();
      $count = (int) $this->afo["main"]["count"];
      $this->caption = $this->afo["main"]["caption"];
      do {
        if (!$this->iid) {
          $this->iid = rand(1, $count);
        }
        $id = "aforisma_" . $this->iid;
        $this->aforisma = $this->afo[$id];
        $desc = $this->afo[$id]["description"];
        if (!$desc) {
          $this->iid = NULL;
        }
      } while ($this->iid == NULL);
      $iid = $this->iid + 1;
      if ($iid > $count) {
        $iid = 1;
      }
      $def["caption"] = "vai a $iid di $count";
      $def["url"] = "#service#?s=AFO&amp;a=SHOW&amp;t=$this->kind_id&amp;c=$this->cid&amp;i=" . $iid;
      $this->register_link("AFO_next", new TLink($def));
      $def["caption"] = $this->afo["main"]["label1"];
      $def["url"] = "#service#?s=AFO&amp;a=SHOW&amp;t=$this->kind_id&amp;c=$this->cid";
      $this->register_link("AFO_random", new TLink($def));
      $def["icon"] = "system_dot3";
      $def["caption"] = "vai a...";
      $def["url"] = "#service#?s=AFO&amp;a=GOTO&amp;t=$this->kind_id&amp;c=$this->cid";
      $this->register_link("AFO_elenco", new TLink($def));
    }
  }
  function getClientCachePolicy() {
    global $_REQUEST;
    if ($_REQUEST["i"]) {
      return 86400;
    } else {
      return -2;
    }
  }
  function getTemplate() {
    return "show";
  }
  function getFooterLinks() {
    return array (
      "AFO_elenco",
      "AFO_home"
    );
  }
}
?>
