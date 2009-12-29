<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
class Service_AFO extends TService {
	function Service_AFO() {
		$this->namespace = "AFO";
		$this->default_action = "START";
		$this->default_page = "MAIN";
	}
	function getAforismoRandom() {
		global $CONFIG;
		$path = $this->findData("index.ini");
		$conf = parse_ini_file($path, true);
		$cat = explode(" ", $conf["kind_1"]["categories"]);
		$key = array_rand($cat);
		$cat = $cat[$key];
		$path = $this->findData($conf["category_$cat"]["path"]);
		$conf = parse_ini_file($path, true);
		$n = (int)$conf["main"]["count"];
		if ($n>1) {
			while (true) {
				$afo = $conf["aforisma_" . rand(1, $n)];
				if ($afo["note"] != NULL) continue;
				if ($afo["significato"] != NULL) continue;
				if ($afo["commento"] != NULL) continue;
				if ($afo["traduzione"] != NULL) continue;
				break;
			}
		}
		else {
			$afo = $conf["aforisma_1"];
		}
		return array($afo["description"], $afo["author"]);
	}
}
?>
