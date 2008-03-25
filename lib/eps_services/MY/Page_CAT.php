<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . "HP" . DIR_SEP . "HPPage.php");
class Page extends HPPage {
  var $cid;
  var $list;
  var $description;
  var $url;
  var $name;
  var $icon;
  function Page(&$res) {
    global $CONFIG;
    parent::HPPage($res);
    $this->baseurl = $CONFIG["URL_service"] . "?a=CAT&amp;i=";
    global $_REQUEST;
    $id = (int) $_REQUEST["i"];
    $this->clientCachePolicy = 0;
    $this->serverCachePolicy = 0;
    $this->proxyCachePolicy = 0;
    $this->cid = "category_" . $id;
    $this->loadPortal();
    $this->saveExitPoint($this->baseurl . "?a=CAT&amp;i=" . $id, $this->getTitle(), "system_channel_icon");
    $this->_cacheKey[] = $this->cid;
  }
  function setup(&$cached) {
    if (!$cached) {
      $this->registerBack($this->cid);
      $this->readCategory($this, $this->cid);
    }
  }
  function getTemplate() {
    return "category";
  }
}
?>
