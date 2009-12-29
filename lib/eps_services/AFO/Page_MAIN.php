<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR."AFO".DIR_SEP."AFOPage.php");
class Page extends AFOPage {
	var $categories;
	var $caption;
	function Page(&$res) {
		parent::AFOPage($res);
	}
	function setup(&$cached) {
		if (!$cached) {
			$this->categories = explode(" ", $this->conf["kind_$this->kind_id"]["categories"]);
			$this->caption = $this->conf["kind_$this->kind_id"]["description"];
			foreach ($this->categories as $id) {
				$def["caption"] = $this->conf["category_$id"]["caption"];
				$def["url"] = "#service#?s=AFO&amp;a=SHOW&amp;t=$this->kind_id&amp;c=$id&amp;i=1";
				$this->register_link("AFO_cat_$id", new TLink($def));
			}
		}
	}
	function getTemplate() {
		return "main";
	}
}
?>
