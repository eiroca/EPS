<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR."PG".DIR_SEP."PGPage.php");
class Page extends PGPage {
	var $cat;
	function Page(&$res) {
		parent::PGPage($res);
	}
	function setup(&$cached) {
		if (!$cached) {
			$this->cat = explode(" ", $this->conf["main"]["categories"]);
			foreach ($this->cat as $id) {
				$def["caption"] = $this->conf["category_$id"]["caption"];
				$img = explode(" ", $this->conf["category_$id"]["files"]);
				$def["url"] = "#service#?s=PG&amp;a=IMG&amp;c=$id&amp;i=" . $img[0];
				$this->register_link("_PG$id", new TLink($def));
			}
		}
	}
	function getTemplate() {
		return "main";
	}
}
?>