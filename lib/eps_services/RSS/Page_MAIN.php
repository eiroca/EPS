<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once(SRV_DIR."RSS".DIR_SEP."RSSPage.php");
class Page extends RSSPage {
	var $news;
	function Page(&$res) {
		parent::RSSPage($res);
	}
	function setup(&$cached) {
		if (!$cached) {
			parent::setup($cached);
			$def["caption"] = $this->rss->channel["title"];
			$def["url"] = "#service#?s=RSS&amp;a=INFO&amp;r=$this->rid";
			$this->register_link("rss_info", new TLink($def));
			unset($def);
			$img = $this->rss->image["url"];
			$def["alt_text"] = " ";
			$def["url"] = $img;
			$info =pathinfo($img);
			$def["format"] = $info["extension"];
			$this->register_image("_IMG", new TImage($def));
			unset($def);
			$def["images"] = "_IMG";
			$def["alt_text"] = " ";
			$this->register_icon("rss_icon", new TIcon($def));
			if ($this->rss) {
				foreach($this->rss->items as $key => $item) {
					$this->news[$key] = "rss_news$key";
					$def["caption"] = $item["title"];
					$def["url"] = "#service#?s=RSS&amp;a=SHOW&amp;r=$this->rid&amp;i=".$key;
					$this->register_link($this->news[$key], new TLink($def));
				}
			}
		}
	}
	function getTemplate() {
		return "main";
	}
}
?>