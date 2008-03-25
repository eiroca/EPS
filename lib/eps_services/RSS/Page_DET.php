<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . "RSS" . DIR_SEP . "RSSPage.php");
class Page extends RSSPage {
  var $nid;
  var $info;
  function Page(&$res) {
    parent::RSSPage($res);
    global $_REQUEST;
    $this->nid = $_REQUEST["i"];
    $this->_cacheKey[] = $this->nid;
  }
  function setup(&$cached) {
    if (!$cached) {
      parent::setup($cached);
      $this->info = $this->rss->items[$this->nid];
      $this->_objects["info"] = "info";
      $def["caption"] = $this->rss->channel["title"];
      $def["url"] = "#service#?s=RSS&amp;r=$this->rid";
      $this->register_link("rss_home", new TLink($def));
      unset ($def);
      $img = $this->rss->image["url"];
      $def["alt_text"] = " ";
      $def["url"] = $img;
      $info = pathinfo($img);
      $def["format"] = $info["extension"];
      $this->register_image("_IMG", new TImage($def));
      unset ($def);
      $def["images"] = "_IMG";
      $def["alt_text"] = " ";
      $this->register_icon("rss_icon", new TIcon($def));
      unset ($def);
      if ($this->conf["type"] == "1") {
        $def["caption"] = "qui";
        $def["url"] = $this->info["pod_url"];
        $this->register_link("rss_link", new TLink($def));
        if ($this->nid > 0) {
          $def["caption"] = "podcast precedente";
          $def["url"] = "#service#?s=RSS&amp;a=SHOW&amp;r=$this->rid&amp;i=" . ($this->nid - 1);
          $this->register_link("rss_prev", new TLink($def));
        }
        if ($this->nid < count($this->rss->items) - 1) {
          $def["caption"] = "podcast successiva";
          $def["url"] = "#service#?s=RSS&amp;a=SHOW&amp;r=$this->rid&amp;i=" . ($this->nid + 1);
          $this->register_link("rss_next", new TLink($def));
        }
      } else {
        $def["caption"] = "qui";
        $def["url"] = $this->info["link"];
        $this->register_link("rss_link", new TLink($def));
        if ($this->nid > 0) {
          $def["caption"] = "notizia precedente";
          $def["url"] = "#service#?s=RSS&amp;a=SHOW&amp;r=$this->rid&amp;i=" . ($this->nid - 1);
          $this->register_link("rss_prev", new TLink($def));
        }
        if ($this->nid < count($this->rss->items) - 1) {
          $def["caption"] = "notizia successiva";
          $def["url"] = "#service#?s=RSS&amp;a=SHOW&amp;r=$this->rid&amp;i=" . ($this->nid + 1);
          $this->register_link("rss_next", new TLink($def));
        }
      }
    }
  }
  function getTemplate() {
    return "show";
  }
  function getFooterLinks() {
    return array (
      "back" => "rss_home"
    );
  }
}
?>
