<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
class AFOPage extends TPage {
	var $conf;
	var $kind_id;
	function AFOPage(&$res) {
		parent::TPage($res);
		global $_REQUEST;
		global $SERVICE;
		$this->kind_id = $_REQUEST["t"];
		if (!$this->kind_id) {
			$this->kind_id = "1";
		}
		$conf_file = $SERVICE->findData("index.ini");
		$this->conf = parse_ini_file($conf_file, true);
		$def["caption"] = $this->conf["kind_$this->kind_id"]["caption"];
		$def["url"] = "#service#?s=AFO&amp;t=$this->kind_id";
		$def["icon"] = "system_pin";
		$this->register_link("AFO_home", new TLink($def));
		$this->_cacheKey[] = $this->kind_id;
	}
	function getTitle() {
		return $this->conf["kind_$this->kind_id"]["caption"];
	}
	function getName() {
		return "Aforismi Service";
	}
}
?>