<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
class HPPage extends TPage {
  var $language;
  var $baseurl;
  function HPPage(&$res) {
    parent::TPage($res);
    global $CONTEXT;
    global $CONFIG;
    $this->language = $CONTEXT->language;
    if ($this->language) {
      $this->_cacheKey[] = $this->language;
    }
    $this->baseurl = $CONFIG["URL_portal"] . "?a=CAT&amp;i=";
  }
  function registerBack($id) {
    $def = $this->conf[$id];
    $back = $def["back"];
    if ($back) {
      $link = &getResourceById("TLink", $back);
      if (!$link) {
        $lnk["caption"] = "Indietro";
        $lnk["icon"] = "system_pin";
        if (strpos($back, "category_") === 0) {
          $i = strtok($back, "_");
          $i = strtok("_");
          $lnk["url"] = $this->baseurl . $i;
          $link = new TLink($lnk);
        }
      }
      if ($link) {
        $this->register_link("back", $link);
      }
    }
  }
  function readCategory(&$cat, $id) {
    $def = $this->conf[$id];
    $this->readMenu($cat->menu, $def["menu"], $id);
    $cat->description = $def["description"];
    $cat->caption = $def["caption"];
    $cat->icon = $def["icon"];
    $cat->clientCachePolicy = $def["serverCachePolicy"];
    $cat->proxyCachePolicy = $def["proxyCachePolicy"];
    $cat->serverCachePolicy = $def["serverCachePolicy"];
    $cat->message = $def["message"];
  }
  function readMenu(&$list, &$menu, $id) {
    $list = explode(" ", $menu);
    foreach ($list as $item) {
      $nam = $item;
      if (strpos($nam, "category_") === 0) {
        $def = $this->conf[$nam];
        $this->buildLink($nam, $def, $nam);
      }
    }
  }
  function buildLink($nam, &$def, $item) {
    $url = $def["url"];
    if ($url == NULL) {
      $i = strtok($item, "_");
      $i = strtok("_");
      $def["url"] = $this->baseurl . $i;
    }
    $this->register_link($nam, new TLink($def));
  }
  function loadPortal() {
    $name = "portal.ini";
    $this->conf = $this->loadConf($name);
  }
  function getTitle() {
    return $this->conf[$this->cid]["caption"];
  }
}
?>