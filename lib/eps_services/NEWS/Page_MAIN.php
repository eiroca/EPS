<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
class Page extends TPage {
	var $news;
	var $links;
	var $last;
	function Page(& $res) {
		parent::TPage($res, "news.ini");
	}
	function setup(& $cached) {
		if (!$cached) {
			parent::setup($cached);
			$conf = $this->loadConf("news.ini");
			$this->readConf($conf, $this->news, "main", "news", "news", "#service#?s=NEWS&amp;a=SHOW&amp;i=", "NEWS_");
			$lastid = "news_" . $conf["main"]["last"];
			$this->last = $conf[$lastid];
		}
	}
	function readConf(&$conf, &$list, $sec, $entry, $base, $base_url, $base_reg) {
		$list = explode(" ", $conf[$sec][$entry]);
		foreach ($list as $item) {
			$nam = $base . "_$item";
			$def = $conf[$nam];
			$url = $def["url"];
			if ($url == NULL) {
				$def["url"] = $base_url . $item;
			}
			$this->register_link($base_reg . $nam, new TLink($def));
		}
	}
	function getTemplate() {
		return "main";
	}
	function getName() {
		return "News Service";
	}
	function getTitle() {
		return "News";
	}
}
?>