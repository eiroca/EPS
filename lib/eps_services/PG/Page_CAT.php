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
	var $cid;
	var $images;
	var $cat;
	function Page(& $res) {
		parent::PGPage($res);
		global $_REQUEST;
		$this->cid = $_REQUEST["c"];
		$this->_cacheKey[] = $this->cid;
	}
	function setup(&$cached) {
		if (!$cached) {
			$this->cat = $this->conf["category_$this->cid"]["caption"];
			$this->images = explode(" ", $this->conf["category_$this->cid"]["files"]);
			foreach ($this->images as $id) {
				$def["caption"] = $this->conf["file_$id"]["caption"];
				$def["url"] = "#service#?s=PG&amp;a=IMG&amp;c=$this->cid&amp;i=$id";
				$this->register_link("_PG$id", new TLink($def));
			}
		}
	}
	function getTemplate() {
		return "category";
	}
	function getFooterLinks() {
		return array ("PG_home");
	}
}
?>